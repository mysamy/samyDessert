import { Application } from '@hotwired/stimulus';
import LiveController from '@symfony/ux-live-component';
import NavToggleController from './controllers/nav_toggle_controller.js';
import CarouselController from './controllers/carousel_controller.js';

const app = Application.start();
app.register('live', LiveController);
app.register('nav-toggle', NavToggleController);
app.register('carousel', CarouselController);