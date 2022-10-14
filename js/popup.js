import {fadescreenOn} from "./utilits.js";

const popup = () => {
  const swiperSlide = document.querySelectorAll('.swiper-slide img');

  swiperSlide.forEach((element) => {
    element.addEventListener('click', () => {
      const galleryWrapper = document.createElement('div');
      const image = document.createElement('img');
      galleryWrapper.classList.add('gallery-wrapper');
      image.classList.add('popup');
      image.src = element.src;
      galleryWrapper.addEventListener('click', () => {
        document.body.removeChild(galleryWrapper);
      });
      document.body.appendChild(galleryWrapper)
      galleryWrapper.appendChild(image);
    });
  });
};

export {popup};
