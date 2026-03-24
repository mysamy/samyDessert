import { Application } from '@hotwired/stimulus';
import LiveController from '@symfony/ux-live-component';
import NavToggleController from './controllers/nav_toggle_controller.js';
import CarouselController from './controllers/carousel_controller.js';
import DropdownController from './controllers/dropdown_controller.js';
import FullcalendarController from './controllers/fullcalendar_controller.js';
import FavoriController from './controllers/favori_controller.js';
import FlashTooltipController from './controllers/flash_tooltip_controller.js';
import CookieBannerController from './controllers/cookie_banner_controller.js';

const app = Application.start();
app.register('live', LiveController);
app.register('nav-toggle', NavToggleController);
app.register('carousel', CarouselController);
app.register('dropdown', DropdownController);
app.register('fullcalendar', FullcalendarController);
app.register('favori', FavoriController);
app.register('flash-tooltip', FlashTooltipController);
app.register('cookie-banner', CookieBannerController);