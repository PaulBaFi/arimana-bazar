// Estado global de la aplicación
let usuarios = [];
let personas = [];
let editingUserId = null;
let userToDelete = null;

// Datos de ejemplo para personas (normalmente vendrían de una API)
const personasEjemplo = [
  { id: 1, nombres: "Juan Carlos", apellidos: "Pérez García", dni: "12345678" },
  {
    id: 2,
    nombres: "María Elena",
    apellidos: "López Martínez",
    dni: "87654321",
  },
  {
    id: 3,
    nombres: "Carlos Alberto",
    apellidos: "Rodríguez Silva",
    dni: "11223344",
  },
  { id: 4, nombres: "Ana Isabel", apellidos: "González Vega", dni: "44332211" },
  {
    id: 5,
    nombres: "Luis Miguel",
    apellidos: "Fernández Torres",
    dni: "55667788",
  },
];

// Datos de ejemplo para usuarios
const usuariosEjemplo = [
  {
    id: 1,
    personaId: 1,
    correo: "juan.perez@empresa.com",
    clave: "password123",
    rol: "ADMIN",
    fechaRegistro: "2024-01-15",
    estado: 1,
  },
  {
    id: 2,
    personaId: 2,
    correo: "maria.lopez@empresa.com",
    clave: "password456",
    rol: "EMPLEADO",
    fechaRegistro: "2024-02-10",
    estado: 1,
  },
  {
    id: 3,
    personaId: 3,
    correo: "carlos.rodriguez@empresa.com",
    clave: "password789",
    rol: "EMPLEADO",
    fechaRegistro: "2024-03-05",
    estado: 0,
  },
];

// Inicialización cuando se carga la página
document.addEventListener("DOMContentLoaded", function () {
  // Cargar datos de ejemplo
  personas = [...personasEjemplo];
  usuarios = [...usuariosEjemplo];

  // Inicializar componentes
  loadPersonas();
  loadUsuarios();
  setupEventListeners();
  setCurrentDate();
});

// Configurar event listeners
function setupEventListeners() {
  // Búsqueda en tiempo real
  const searchInput = document.getElementById("searchInput");
  searchInput.addEventListener("input", handleSearch);

  // Formulario de usuario
  const usuarioForm = document.getElementById("usuarioForm");
  usuarioForm.addEventListener("submit", handleFormSubmit);

  // Cerrar formulario con Escape
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
      closeForm();
      closeDeleteModal();
    }
  });

  // Validación en tiempo real
  setupRealTimeValidation();
}

// Configurar validación en tiempo real
function setupRealTimeValidation() {
  const correoInput = document.getElementById("correo");
  const claveInput = document.getElementById("clave");

  correoInput.addEventListener("blur", () => validateEmail(correoInput.value));
  claveInput.addEventListener("blur", () => validatePassword(claveInput.value));
}

// Cargar personas en el select
function loadPersonas() {
  const personaSelect = document.getElementById("personaId");
  personaSelect.innerHTML = '<option value="">Seleccione una persona</option>';

  // Filtrar personas que no tienen usuario asignado (excepto al editar)
  const personasDisponibles = personas.filter((persona) => {
    const tieneUsuario = usuarios.some(
      (usuario) =>
        usuario.personaId === persona.id &&
        (editingUserId === null || usuario.id !== editingUserId)
    );
    return !tieneUsuario;
  });

  personasDisponibles.forEach((persona) => {
    const option = document.createElement("option");
    option.value = persona.id;
    option.textContent = `${persona.nombres} ${persona.apellidos} - ${persona.dni}`;
    personaSelect.appendChild(option);
  });
}

// Cargar y mostrar usuarios en la tabla
function loadUsuarios(usuariosToShow = null) {
  const tbody = document.getElementById("usuariosTableBody");
  const usuariosData = usuariosToShow || usuarios;

  if (usuariosData.length === 0) {
    tbody.innerHTML = `
            <tr>
                <td colspan="8" class="empty-state">
                    <h3>No hay usuarios registrados</h3>
                    <p>Comienza agregando tu primer usuario</p>
                </td>
            </tr>
        `;
    return;
  }

  tbody.innerHTML = usuariosData
    .map((usuario) => {
      const persona = personas.find((p) => p.id === usuario.personaId);
      const personaInfo = persona
        ? `${persona.nombres} ${persona.apellidos}`
        : "Persona no encontrada";
      const dni = persona ? persona.dni : "N/A";

      return `
            <tr>
                <td>${usuario.id}</td>
                <td>${personaInfo}</td>
                <td>${dni}</td>
                <td class="correo-cell">${usuario.correo}</td>
                <td><span class="rol-badge rol-${usuario.rol.toLowerCase()}">${
        usuario.rol
      }</span></td>
                <td><span class="status-badge status-${
                  usuario.estado ? "active" : "inactive"
                }">${usuario.estado ? "Activo" : "Inactivo"}</span></td>
                <td>${formatDate(usuario.fechaRegistro)}</td>
                <td class="actions">
                    <button class="btn btn-sm btn-edit" onclick="editUser(${
                      usuario.id
                    })" title="Editar usuario">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-delete" onclick="deleteUser(${
                      usuario.id
                    })" title="Eliminar usuario">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    })
    .join("");
}

// Búsqueda de usuarios
function handleSearch(e) {
  const searchTerm = e.target.value.toLowerCase().trim();

  if (!searchTerm) {
    loadUsuarios();
    return;
  }

  const filteredUsuarios = usuarios.filter((usuario) => {
    const persona = personas.find((p) => p.id === usuario.personaId);
    const personaInfo = persona
      ? `${persona.nombres} ${persona.apellidos}`.toLowerCase()
      : "";
    const dni = persona ? persona.dni : "";

    return (
      personaInfo.includes(searchTerm) ||
      usuario.correo.toLowerCase().includes(searchTerm) ||
      usuario.rol.toLowerCase().includes(searchTerm) ||
      dni.includes(searchTerm)
    );
  });

  loadUsuarios(filteredUsuarios);
}

// Abrir formulario (crear o editar)
function openForm(mode, userId = null) {
  const formSection = document.getElementById("formSection");
  const formTitle = document.getElementById("formTitle");
  const submitBtn = document.getElementById("submitBtn");

  editingUserId = userId;

  if (mode === "create") {
    formTitle.textContent = "Agregar Usuario";
    submitBtn.textContent = "Guardar Usuario";
    resetForm();
    setCurrentDate();
  } else if (mode === "edit") {
    formTitle.textContent = "Editar Usuario";
    submitBtn.textContent = "Actualizar Usuario";
    loadUserData(userId);
  }

  loadPersonas(); // Recargar personas disponibles
  formSection.classList.add("active");

  // Enfocar el primer campo
  setTimeout(() => {
    document.getElementById("personaId").focus();
  }, 300);
}

// Cerrar formulario
function closeForm() {
  const formSection = document.getElementById("formSection");
  formSection.classList.remove("active");
  resetForm();
  editingUserId = null;
}

// Cargar datos del usuario para edición
function loadUserData(userId) {
  const usuario = usuarios.find((u) => u.id === userId);
  if (!usuario) {
    showNotification("Usuario no encontrado", "error");
    return;
  }

  document.getElementById("personaId").value = usuario.personaId;
  document.getElementById("correo").value = usuario.correo;
  document.getElementById("clave").value = usuario.clave;
  document.getElementById("rol").value = usuario.rol;
  document.getElementById("fechaRegistro").value = usuario.fechaRegistro;
  document.getElementById("estado").value = usuario.estado;
}

// Resetear formulario
function resetForm() {
  const form = document.getElementById("usuarioForm");
  form.reset();
  clearErrors();
  setCurrentDate();
  document.getElementById("estado").value = "1"; // Activo por defecto
}

// Establecer fecha actual
function setCurrentDate() {
  const today = new Date().toISOString().split("T")[0];
  document.getElementById("fechaRegistro").value = today;
}

// Manejar envío del formulario
function handleFormSubmit(e) {
  e.preventDefault();

  if (!validateForm()) {
    return;
  }

  const formData = {
    personaId: parseInt(document.getElementById("personaId").value),
    correo: document.getElementById("correo").value.trim(),
    clave: document.getElementById("clave").value,
    rol: document.getElementById("rol").value,
    fechaRegistro: document.getElementById("fechaRegistro").value,
    estado: parseInt(document.getElementById("estado").value),
  };

  if (editingUserId) {
    updateUser(editingUserId, formData);
  } else {
    createUser(formData);
  }
}

// Crear nuevo usuario
function createUser(userData) {
  // Verificar si el correo ya existe
  if (
    usuarios.some(
      (u) => u.correo.toLowerCase() === userData.correo.toLowerCase()
    )
  ) {
    showError("correo", "Este correo electrónico ya está registrado");
    return;
  }

  const newUser = {
    id: getNextUserId(),
    ...userData,
  };

  usuarios.push(newUser);
  loadUsuarios();
  closeForm();
  showNotification("Usuario creado exitosamente", "success");
}

// Actualizar usuario existente
function updateUser(userId, userData) {
  const userIndex = usuarios.findIndex((u) => u.id === userId);
  if (userIndex === -1) {
    showNotification("Usuario no encontrado", "error");
    return;
  }

  // Verificar si el correo ya existe (excluyendo el usuario actual)
  if (
    usuarios.some(
      (u) =>
        u.id !== userId &&
        u.correo.toLowerCase() === userData.correo.toLowerCase()
    )
  ) {
    showError("correo", "Este correo electrónico ya está registrado");
    return;
  }

  usuarios[userIndex] = { ...usuarios[userIndex], ...userData };
  loadUsuarios();
  closeForm();
  showNotification("Usuario actualizado exitosamente", "success");
}

// Editar usuario
function editUser(userId) {
  openForm("edit", userId);
}

// Eliminar usuario
function deleteUser(userId) {
  userToDelete = userId;
  const deleteModal = document.getElementById("deleteModal");
  deleteModal.classList.add("active");
}

// Confirmar eliminación
function confirmDelete() {
  if (userToDelete) {
    const userIndex = usuarios.findIndex((u) => u.id === userToDelete);
    if (userIndex !== -1) {
      usuarios.splice(userIndex, 1);
      loadUsuarios();
      showNotification("Usuario eliminado exitosamente", "success");
    }
  }
  closeDeleteModal();
}

// Cerrar modal de eliminación
function closeDeleteModal() {
  const deleteModal = document.getElementById("deleteModal");
  deleteModal.classList.remove("active");
  userToDelete = null;
}

// Validar formulario completo
function validateForm() {
  clearErrors();
  let isValid = true;

  // Validar persona
  const personaId = document.getElementById("personaId").value;
  if (!personaId) {
    showError("personaId", "Debe seleccionar una persona");
    isValid = false;
  }

  // Validar correo
  const correo = document.getElementById("correo").value.trim();
  if (!correo) {
    showError("correo", "El correo electrónico es requerido");
    isValid = false;
  } else if (!validateEmail(correo)) {
    isValid = false;
  }

  // Validar contraseña
  const clave = document.getElementById("clave").value;
  if (!clave) {
    showError("clave", "La contraseña es requerida");
    isValid = false;
  } else if (!validatePassword(clave)) {
    isValid = false;
  }

  // Validar rol
  const rol = document.getElementById("rol").value;
  if (!rol) {
    showError("rol", "Debe seleccionar un rol");
    isValid = false;
  }

  return isValid;
}

// Validar email
function validateEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    showError("correo", "Ingrese un correo electrónico válido");
    return false;
  }
  return true;
}

// Validar contraseña
function validatePassword(password) {
  if (password.length < 6) {
    showError("clave", "La contraseña debe tener al menos 6 caracteres");
    return false;
  }
  if (password.length > 25) {
    showError("clave", "La contraseña no puede tener más de 25 caracteres");
    return false;
  }
  return true;
}

// Mostrar error en campo específico
function showError(fieldId, message) {
  const field = document.getElementById(fieldId);
  const errorElement = document.getElementById(fieldId + "Error");

  field.parentElement.classList.add("error");
  errorElement.textContent = message;
  errorElement.style.display = "block";
}

// Limpiar todos los errores
function clearErrors() {
  const errorElements = document.querySelectorAll(".error-message");
  const formGroups = document.querySelectorAll(".form-group");

  errorElements.forEach((el) => {
    el.style.display = "none";
    el.textContent = "";
  });

  formGroups.forEach((group) => {
    group.classList.remove("error");
  });
}

// Mostrar notificación
function showNotification(message, type = "success") {
  // Remover notificación existente
  const existingNotification = document.querySelector(".notification");
  if (existingNotification) {
    existingNotification.remove();
  }

  const notification = document.createElement("div");
  notification.className = `notification ${type}`;
  notification.textContent = message;

  document.body.appendChild(notification);

  // Mostrar notificación
  setTimeout(() => {
    notification.classList.add("show");
  }, 100);

  // Ocultar notificación después de 3 segundos
  setTimeout(() => {
    notification.classList.remove("show");
    setTimeout(() => {
      if (notification.parentNode) {
        notification.remove();
      }
    }, 300);
  }, 3000);
}

// Obtener siguiente ID de usuario
function getNextUserId() {
  return usuarios.length > 0 ? Math.max(...usuarios.map((u) => u.id)) + 1 : 1;
}

// Formatear fecha para mostrar
function formatDate(dateString) {
  const date = new Date(dateString);
  return date.toLocaleDateString("es-ES", {
    year: "numeric",
    month: "2-digit",
    day: "2-digit",
  });
}

// Funciones utilitarias adicionales

// Exportar datos (opcional)
function exportUsers() {
  const dataStr = JSON.stringify(usuarios, null, 2);
  const dataBlob = new Blob([dataStr], { type: "application/json" });
  const url = URL.createObjectURL(dataBlob);
  const link = document.createElement("a");
  link.href = url;
  link.download = "usuarios.json";
  link.click();
  URL.revokeObjectURL(url);
}

// Filtros adicionales (opcional)
function filterByRole(role) {
  const filteredUsers =
    role === "ALL" ? usuarios : usuarios.filter((u) => u.rol === role);
  loadUsuarios(filteredUsers);
}

function filterByStatus(status) {
  const filteredUsers =
    status === "ALL"
      ? usuarios
      : usuarios.filter((u) => u.estado === parseInt(status));
  loadUsuarios(filteredUsers);
}

// Estadísticas básicas (opcional)
function getUserStats() {
  const totalUsers = usuarios.length;
  const activeUsers = usuarios.filter((u) => u.estado === 1).length;
  const adminUsers = usuarios.filter((u) => u.rol === "ADMIN").length;
  const employeeUsers = usuarios.filter((u) => u.rol === "EMPLEADO").length;

  return {
    total: totalUsers,
    active: activeUsers,
    inactive: totalUsers - activeUsers,
    admins: adminUsers,
    employees: employeeUsers,
  };
}

// Log de actividades (para debugging)
function logActivity(action, details) {
  console.log(`[${new Date().toISOString()}] ${action}:`, details);
}
