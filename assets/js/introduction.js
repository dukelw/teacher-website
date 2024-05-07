
/*=============== EMAIL JS ===============*/
const contactForm =document.getElementById('contact-form'),
contactMessage = document.getElementById('contact-message')
const sendMail = (e) => {
    e.preventDefault()
    emailjs.sendForm('service_c40dzbe','template_svfqa8q','#contact-form','c7L8U9xM7z_0uUnaD').then(() => {
        contactMessage.textContent='Message sent successfully'
        setTimeout(()=>
            {
                contactMessage.textContent = ''
            },5000)

        contactForm.reset()
    },()=> {
        contactMessage.textContent= 'Message not sent (service error)'
    })


}
contactForm.addEventListener('submit', sendMail)
/*=============== SHOW SCROLL UP ===============*/ 
const scrollup = () => {
    const scrollUp = document.getElementById('scroll-up')
    this.scrollY >= 350 ? scrollUp.classList.add('show-scroll')
    : scrollUp.classList.remove('show-scroll')
}
window.addEventListener('scroll',scrollup)
/*=============== SCROLL SECTIONS ACTIVE LINK ===============*/
/*=============== DARK LIGHT THEME ===============*/ 


/*=============== SCROLL REVEAL ANIMATION ===============*/
const sr = ScrollReveal({
    origin:'top',
    distance: '60px',
    duration: 2500,
    delay: 400
})
sr.reveal(`.home__perfil,.about__image,.contact__mail`,{origin:'right'})
sr.reveal(`.home__name,.home__info,about__container .section__title-1, .about__info,.contact__social, .contact__data`,{origin:'left'})
sr.reveal(`.services__card`,{interval:100})
