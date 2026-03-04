import { Application } from '@hotwired/stimulus';
import NavToggleController from './controllers/nav_toggle_controller.js';

const app = Application.start();
app.register('nav-toggle', NavToggleController);
