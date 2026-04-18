import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['menu'];

    connect() {
        this.open = false;
        // Ferme le dropdown si on clique ailleurs
        this._clickOutside = (e) => {
            if (!this.element.contains(e.target)) this.close();
        };
        document.addEventListener('click', this._clickOutside);
    }

    disconnect() {
        document.removeEventListener('click', this._clickOutside);
    }

    toggle() {
        this.open ? this.close() : this.show();
    }

    show() {
        this.open = true;
        this.menuTarget.classList.remove('hidden');
        this.element.querySelector('button').setAttribute('aria-expanded', 'true');
    }

    close() {
        this.open = false;
        this.menuTarget.classList.add('hidden');
        this.element.querySelector('button').setAttribute('aria-expanded', 'false');
    }
}
