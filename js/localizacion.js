const dataUbicacion = {
  Lima: {
    Lima: ["Miraflores", "San Isidro", "Surco", "San Juan de Lurigancho"],
    Huaral: ["Chancay", "Aucallama", "Huaral"],
  },
  Cusco: {
    Cusco: ["Santiago", "San Sebastián", "Wanchaq"],
    Urubamba: ["Urubamba", "Ollantaytambo", "Yucay"],
  },
  Arequipa: {
    Arequipa: ["Cercado", "Cayma", "Yanahuara"],
    Camana: ["Camana", "Mariscal Cáceres"],
  },
};

const departamentoSelect = document.getElementById("departamento");
const provinciaSelect = document.getElementById("provincia");
const distritoSelect = document.getElementById("distrito");

Object.keys(dataUbicacion).forEach((depto) => {
  const opt = document.createElement("option");
  opt.value = depto;
  opt.textContent = depto;
  departamentoSelect.appendChild(opt);
});

departamentoSelect.addEventListener("change", function () {
  const selectedDepto = this.value;

  provinciaSelect.innerHTML = '<option value="">— Seleccionar —</option>';
  distritoSelect.innerHTML = '<option value="">— Seleccionar —</option>';
  distritoSelect.disabled = true;

  if (selectedDepto) {
    const provincias = Object.keys(dataUbicacion[selectedDepto]);
    provincias.forEach((prov) => {
      const opt = document.createElement("option");
      opt.value = prov;
      opt.textContent = prov;
      provinciaSelect.appendChild(opt);
    });
    provinciaSelect.disabled = false;
  } else {
    provinciaSelect.disabled = true;
    distritoSelect.disabled = true;
  }
});

provinciaSelect.addEventListener("change", function () {
  const selectedDepto = departamentoSelect.value;
  const selectedProv = this.value;

  distritoSelect.innerHTML = '<option value="">-- Seleccionar --</option>';

  if (selectedProv) {
    const distritos = dataUbicacion[selectedDepto][selectedProv];
    distritos.forEach((dist) => {
      const opt = document.createElement("option");
      opt.value = dist;
      opt.textContent = dist;
      distritoSelect.appendChild(opt);
    });
    distritoSelect.disabled = false;
  } else {
    distritoSelect.disabled = true;
  }
});
