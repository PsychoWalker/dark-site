const mobileMenu = () => {
  const togglemenu = document.querySelector('#togglemenu');
  const menuPhone = document.querySelector('.menu-info-block:nth-child(3)');
  const logo = document.querySelector('.menu__logo');
  const link = document.querySelectorAll('.navbar-header__item a');

  togglemenu.addEventListener('click', () => {
    document.querySelector('.mobile-menu').classList.toggle('activeMenu');
    togglemenu.classList.toggle('change');
    menuPhone.classList.toggle('hide');
    logo.classList.toggle('activeLogo');
    document.querySelector('.menu-info-block:nth-child(2) a:first-of-type').classList.toggle('hide');
  });

  link.forEach((element) => {
    element.addEventListener('click', () => {
      document.querySelector('.mobile-menu').classList.toggle('activeMenu');
      togglemenu.classList.toggle('change');
      logo.classList.toggle('activeLogo');
      document.querySelector('.menu-info-block:nth-child(2) a:first-of-type').classList.toggle('hide');
    });
  });
}

export {mobileMenu};
