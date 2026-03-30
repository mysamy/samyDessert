import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['input', 'iconShow', 'iconHide', 'btn']

  toggle() {
    const isPassword = this.inputTarget.type === 'password'
    this.inputTarget.type = isPassword ? 'text' : 'password'
    this.iconShowTarget.style.display = isPassword ? 'none' : ''
    this.iconHideTarget.style.display = isPassword ? '' : 'none'
    this.btnTarget.setAttribute('aria-label', isPassword ? 'Masquer le mot de passe' : 'Afficher le mot de passe')
  }
}
