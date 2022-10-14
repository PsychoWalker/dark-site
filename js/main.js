import {activeMaskInput, maskHundred, scrolling, checkedPolitic} from "./utilits.js";
import {sendPhone} from "./callback.js";
import {mobileMenu} from "./mobile.js";
import {calculate,showModal} from "./calculator.js";
import {check} from "./tabs.js";
import {popup} from "./popup.js";
import {getElementShowler, loaded} from "./animation.js";

/* Отправка форм */
sendPhone('footer-form','/dark-site/callback/form-footer/');
sendPhone('consult','/dark-site/callback/form-footer/');
sendPhone('form-phone', '/dark-site/callback/form-phone/');
sendPhone('callback__free', '/dark-site/callback/form-phone/');
sendPhone('modal-form','/dark-site/callback/form-footer/');
/* Анимация на странице */
getElementShowler('.price__block-item', 'animationRun', true, 0);
getElementShowler('.why__block-item', 'animationRun', false, 0);
getElementShowler('.get__lest-item', 'animationRun', true, 0);
getElementShowler('.service__block-item', 'animationRun', true, 0);
getElementShowler('.infinity__block', 'animationRun', true, 0);
getElementShowler('.count', 'animationRun', false, 10);
getElementShowler('.countTwo', 'animationRun', false, 20);
getElementShowler('.count-1', 'animationRun', false, 100);
getElementShowler('.count-2', 'animationRun', false, 10);
getElementShowler('.count-3', 'animationRun', false, 11);
getElementShowler('.count-4', 'animationRun', false, 45);

checkedPolitic('.politics__check');
loaded();
activeMaskInput();
check();
calculate();
mobileMenu();
scrolling();
maskHundred();
popup();

