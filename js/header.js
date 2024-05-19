document.addEventListener("DOMContentLoaded", function() {
    const login = document.getElementById('login'),
          loginBtn = document.getElementById('login-btn'),
          loginClose = document.getElementById('login-close')
  
      /* Login show */
      loginBtn.addEventListener('click', () =>{
        login.classList.add('show-login')
      })
  
      /* Login hidden */
      loginClose.addEventListener('click', () =>{
        login.classList.remove('show-login')
      })
})


