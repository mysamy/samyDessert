import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['menu', 'iconOpen', 'iconClose']

  connect() {
    this.isOpen = false
    this.iconOpenTarget.style.display = ''
    this.iconCloseTarget.style.display = 'none'
    this.onResize = () => {
      if (window.innerWidth >= 1024 && this.isOpen) this.close()
    }
    this.onKeydown = (e) => {
      if (e.key === 'Escape' && this.isOpen) this.close()
    }
    window.addEventListener('resize', this.onResize)
    window.addEventListener('keydown', this.onKeydown)
  }

  disconnect() {
    window.removeEventListener('resize', this.onResize)
    window.removeEventListener('keydown', this.onKeydown)
  }

  toggle() {
    this.isOpen ? this.close() : this.open()
  }

  open() {
    this.isOpen = true
    this.menuTarget.show()
    this.menuTarget.classList.remove('nav-menu-leave')
    this.menuTarget.classList.add('nav-menu-enter')
    this.iconOpenTarget.style.display = 'none'
    this.iconCloseTarget.style.display = ''
  }

  close() {
    this.isOpen = false
    this.menuTarget.classList.remove('nav-menu-enter')
    this.menuTarget.classList.add('nav-menu-leave')
    this.menuTarget.addEventListener('animationend', () => {
      this.menuTarget.close()
      this.menuTarget.classList.remove('nav-menu-leave')
    }, { once: true })
    this.iconOpenTarget.style.display = ''
    this.iconCloseTarget.style.display = 'none'
  }
}
