const check = () => {
  const checker = document.querySelectorAll('.tab input');

  checker.forEach((element) => {
    element.addEventListener('change', () => {
      const upper = document.querySelector('.upper');
      upper.classList.remove('upper');
      element.parentElement.classList.toggle('upper');
    });
  });
}

export {check};
