const sendPhone = (name, path) => {
  const formPhone = document.querySelector('.' + name);
  const btnForm = formPhone.querySelector('button');
  const inputsForm = formPhone.querySelectorAll('input');

  formPhone.addEventListener('submit', (e) => {
    e.preventDefault();
    let formData = new FormData(e.currentTarget);
    let response = fetch(path, {
      method: 'POST',
      body: formData,
    }).then((response) => {
      btnForm.setAttribute('disabled', 'disabled');
      inputsForm.forEach((element) => {
        element.setAttribute('disabled', 'disabled');
        element.classList.add('disable');
      });
      btnForm.classList.add('acceptBtn');
      btnForm.innerHTML = 'Заявка отправлена!';
    });
    formPhone.reset();
  });
}



export {sendPhone};
