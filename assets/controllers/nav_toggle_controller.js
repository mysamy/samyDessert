import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['menu', 'iconOpen', 'iconClose']

  connect() {
    this.isOpen = false
    this.onResize = () => {
      if (window.innerWidth >= 768 && this.isOpen) this.close()
    }
    window.addEventListener('resize', this.onResize)
  }

  disconnect() {
    window.removeEventListener('resize', this.onResize)
  }

  toggle() {
    this.isOpen ? this.close() : this.open()
  }

  open() {
    this.isOpen = true
    this.menuTarget.classList.remove('hidden')
    this.iconOpenTarget.classList.add('hidden')
    this.iconCloseTarget.classList.remove('hidden')
  }

  close() {
    this.isOpen = false
    this.menuTarget.classList.add('hidden')
    this.iconOpenTarget.classList.remove('hidden')
    this.iconCloseTarget.classList.add('hidden')
  }
}
