const userName = "Admin";

function getGreeting() {
  const hour = new Date().getHours();
  if (hour >= 6 && hour < 12) return "☀️ Buenos días";
  if (hour >= 12 && hour < 18) return "🌤️ Buenas tardes";
  return "🌙 Buenas noches";
}

function showGreeting(name) {
  const greetingElement = document.getElementById("greeting");
  const greeting = getGreeting();
  greetingElement.textContent = `${greeting}, ${name}! Bienvenido a tu panel de control.`;
}

showGreeting(userName);
