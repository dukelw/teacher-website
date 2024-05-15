document.addEventListener("DOMContentLoaded", function () {
  const darkModeOptions = {
    bottom: "32px", // default: '32px'
    right: "32px", // default: '32px'
    left: "unset", // default: 'unset'
    time: "0.5s", // default: '0.3s'
    mixColor: "#fff", // default: '#fff'
    backgroundColor: "#fff", // default: '#fff'
    buttonColorDark: "#100f2c", // default: '#100f2c'
    buttonColorLight: "#fff", // default: '#fff'
    saveInCookies: true, // default: true,
    label: "🌓", // default: ''
    autoMatchOsTheme: true, // default: true
  };

  const darkmode = new Darkmode(darkModeOptions);
  darkmode.showWidget();

  // Check the localStorage for the dark mode setting
  const darkMode = localStorage.getItem("mode");
  if (darkMode === "dark") {
    darkmode.toggle();
  }

  // Listen for dark mode toggle
  document
    .getElementById("darkModeToggle")
    .addEventListener("click", function () {
      darkmode.toggle();
      const darkModeEnabled = document.body.classList.contains(
        "darkmode--activated"
      );
      localStorage.setItem("mode", darkModeEnabled ? "dark" : "light");
    });
});
