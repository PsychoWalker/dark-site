/* Маска для телефонных инпутов */
const fadeScreen = document.querySelector('.fadescreen');
const close = document.querySelector('.close-modal');

const activeMaskInput = () => {
  let imasks = document.querySelectorAll('.phonesMask');
  let maskOptions = {
    mask: '+{7}(000)000-00-00'
  };
  for (let i = 0; i < imasks.length; i++) {
    let mask = IMask(imasks[i], maskOptions);
  }
}

const maskHundred = () => {
  let separator = IMask(
    document.querySelector('.separator'),
    {
      mask: Number,
      min: 10000,
      max: 999999999,
      thousandsSeparator: ' '
    });
}

const fadescreenOn = () => {
  fadeScreen.classList.add('show');
}

const fadescreenOff = () => {
  const show = document.querySelectorAll('.show');
  show.forEach((element) => {
    element.classList.remove('show');
  });
}

fadeScreen.addEventListener('click', () => {
  fadescreenOff();
});

close.addEventListener('click', fadescreenOff());

/*Мягкий скролл*/

const scrolling = () => {
  const anchors = document.querySelectorAll('a[href*="#"]');

  for (let anchor of anchors) {
    anchor.addEventListener('click', function (e) {
      e.preventDefault()

      const blockID = anchor.getAttribute('href').substr(1)

      window.scrollTo({
        top: document.getElementById(blockID).offsetTop - 50,
        behavior: "smooth"
      });

    })
  }
};

const checkedPolitic = (formName) => {
  const form = document.querySelectorAll(`${formName}`);

  form.forEach((element) => {
    const checkbox = element.querySelector('input[type="checkbox"]');
    const button = element.querySelector('button');

    checkbox.addEventListener('click', () => {
      checkbox.checked ? button.removeAttribute('disabled') : button.setAttribute('disabled', 'true');
    });
  });
}


export {activeMaskInput, fadescreenOn, fadescreenOff, scrolling, maskHundred, checkedPolitic};
