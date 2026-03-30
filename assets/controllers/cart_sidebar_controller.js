import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['panel']

  open() {
    this.panelTarget.showModal()
    this.panelTarget.offsetHeight // force reflow pour déclencher la transition
    this.panelTarget.classList.remove('translate-x-full')
  }

  close() {
    this.panelTarget.classList.add('translate-x-full')
    setTimeout(() => this.panelTarget.close(), 300)
  }

  // Escape natif → on intercept pour animer la fermeture
  handleCancel(event) {
    event.preventDefault()
    this.close()
  }

  // Clic sur le backdrop natif (target = le dialog lui-même)
  handleBackdropClick(event) {
    if (event.target === this.panelTarget) {
      this.close()
    }
  }
}
