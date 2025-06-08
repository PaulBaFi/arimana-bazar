const getUsers = () => {
  return new Promise((resolve) => {
    setTimeout(() => resolve(window.USERS), 500);
  });
};

getUsers().then((users) => {
  const tbody = document.getElementById("usuarios-body");

  users.forEach((user) => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${user.id}</td>
      <td>${user.nombres} ${user.ape_paterno} ${user.ape_materno}</td>
      <td>${user.dni}</td>
      <td>${user.telefono}</td>
      <td>${user.direccion}</td>
      <td>${user.nacimiento}</td>
      <td>${user.nombreCargo}</td>
      <td>${user.nombreContrato}</td>
      <td>${user.turno}</td>
      <td>${user.tipoUsuario}</td>
      <td class="group-btns">
        <button class="action-btn edit-btn" onclick="editUser(${user.id})">
            <i class="fas fa-edit"></i>
        </button>
        <button class="action-btn delete-btn" onclick="deleteUser(${user.id})">
            <i class="fas fa-trash"></i>
        </button>
      </td>
    `;
    tbody.appendChild(row);
  });
});
