const loaded = () => {
  window.addEventListener('DOMContentLoaded', () => {
    document.body.classList.add('loaded');
  });
}
/* Счётчик */
const runningCount = (elementCount, speed) => {
  const element = document.querySelector(`${elementCount}`);
  let COUNT = element.textContent;
  let getCount = Number(element.getAttribute("data-count"));

  setInterval(() => {
    if (COUNT >= getCount+1) {
      clearInterval();
    } else {
      element.innerHTML = COUNT;
      COUNT++;
    }
  }, speed);
}

const getElementShowler = (getElement, addClass, cascade, speed) => {
  function onEntry(entry) {
    entry.forEach(change => {
      if (change.isIntersecting) { //Когда в зоне видимости
        if (cascade) {
          task (); // Воспроизводит появление объектов анимации последовательно
        } else {
          change.target.classList.add(addClass); // Воспроизводит появление объектов анимации одновременно
        }
        if (speed !== 0) {
          runningCount(getElement, speed);
        }
      }
    });
  }
  let options = { threshold: [0.5] };
  let observer = new IntersectionObserver(onEntry, options);
  let elements = document.querySelectorAll(getElement);
  for (let elm of elements) {
    observer.observe(elm);
  }

  /* Промис с await и последовательным добавлением класса */
  const task = async () => {
    for (const item of elements) {
      await new Promise(r => setTimeout(r, 200));
      item.classList.add(addClass);
    }
  }
}

export {loaded, getElementShowler, runningCount};
