// Controller Stimulus réutilisable pour afficher un message temporaire (tooltip)
// Usage : data-controller="flash-tooltip" sur le conteneur,
//         data-action="click->flash-tooltip#show" sur le déclencheur,
//         data-flash-tooltip-target="message" sur l'élément à afficher/cacher
import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['message']
  static values = { duration: { type: Number, default: 3000 } }

  show() {
    const el = this.messageTarget
    el.classList.remove('hidden')

    clearTimeout(this._timer)
    this._timer = setTimeout(() => el.classList.add('hidden'), this.durationValue)
  }

  hide() {
    this.messageTarget.classList.add('hidden')
    clearTimeout(this._timer)
  }
}
