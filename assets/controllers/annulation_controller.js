import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['dialog', 'ref']

  connect () {
    const id = this.dialogTarget.id
    this.element.querySelector(`[data-dialog-close="${id}"]`)
      ?.addEventListener('click', () => this.dialogTarget.close())
    this.element.querySelector(`[data-dialog-confirm="${id}"]`)
      ?.addEventListener('click', () => this._submit())
    this.dialogTarget.addEventListener('click', (e) => {
      if (e.target === this.dialogTarget) this.dialogTarget.close()
    })
  }

  open (event) {
    const btn = event.currentTarget
    this.refTarget.textContent = btn.dataset.ref
    this._actionUrl = btn.dataset.actionUrl
    this._token = btn.dataset.token
    this.dialogTarget.showModal()
  }

  _submit () {
    const form = document.createElement('form')
    form.method = 'POST'
    form.action = this._actionUrl
    const input = document.createElement('input')
    input.type = 'hidden'
    input.name = '_token'
    input.value = this._token
    form.appendChild(input)
    document.body.appendChild(form)
    form.submit()
  }
}
