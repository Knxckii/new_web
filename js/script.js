const toggleButton = document.querySelector('.toggle-button');
const listContainer = document.querySelector('.list-container');
const home = document.querySelector('.home');


toggleButton.addEventListener("click", () =>{

    listContainer.classList.toggle("active")
    btnPopup.classList.toggle("active")
    home.classList.toggle("active")

})

const wrapper = document.querySelector('.wrapper');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const btnPopup = document.querySelector('.btnLogin-popup');
const iconClose = document.querySelector('.icon-close');

registerLink.addEventListener('click', ()=> {
    wrapper.classList.add('active');
});

loginLink.addEventListener('click', ()=> {
    wrapper.classList.remove('active');
});

btnPopup.addEventListener('click', ()=> {
    wrapper.classList.remove('active');
    wrapper.classList.add('active-popup');
});

iconClose.addEventListener('click', ()=> {
    wrapper.classList.remove('active-popup');
});
