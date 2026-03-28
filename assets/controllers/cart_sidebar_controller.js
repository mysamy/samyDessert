import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['panel', 'backdrop']

  open() {
    document.body.style.overflow = 'hidden'
    this.backdropTarget.classList.remove('hidden')
    // Force reflow pour que la transition se déclenche
    this.panelTarget.offsetHeight
    this.panelTarget.classList.remove('translate-x-full')
    this.backdropTarget.classList.remove('opacity-0')
  }

  close() {
    this.panelTarget.classList.add('translate-x-full')
    this.backdropTarget.classList.add('opacity-0')
    setTimeout(() => {
      this.backdropTarget.classList.add('hidden')
      document.body.style.overflow = ''
    }, 300)
  }

  // Fermer avec Échap
  closeOnEscape(event) {
    if (event.key === 'Escape') this.close()
  }
}
