import {fadescreenOff, fadescreenOn} from './utilits.js';
const showModal = () => {

  const modalShow = document.querySelector('.modal-calc');
  const btnShow = document.querySelectorAll('.tableBank button');
  const fillableField = document.querySelectorAll('.block-left p span');
  const bankName = document.querySelector('.bank-name');
  btnShow.forEach((element) => {
    element.addEventListener('click', () => {

      modalShow.classList.add('show');
      fadescreenOn();

      const info = element.parentElement.parentElement.querySelectorAll('td');
      const checked = document.querySelector('.radioFz:checked');
      const lawChecked = document.querySelector('#garant');

      fillableField[0].innerText = checked.getAttribute('data-rem');
      fillableField[1].innerText = info[4].innerHTML;
      fillableField[2].innerText = garant.value;
      fillableField[3].innerText = info[3].innerHTML;
      bankName.innerText = info[0].innerHTML;
      const close = document.querySelector('.close-modal');
      close.addEventListener('click', () => {
        fadescreenOff();
      });
    });
  });
}

const calculate = () => {
  const calcForm = document.querySelector('.calc');

  calcForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    document.querySelector('.spin-wrapper').classList.add('show');
    let formData = new FormData(e.currentTarget);
    let response = await fetch( '../calc/index.php', {
      method: 'POST',
      body: formData,
    });
    document.querySelector('.spin-wrapper').classList.remove('show');
    if (response.status == 200) {
      let responseText = await response.text();
      let el = document.querySelector('table.tableBank');
      if (el) {
        el.innerHTML = responseText;
        showModal();
        fadescreenOff();
      }
    }
  });
};

export {calculate,showModal};
