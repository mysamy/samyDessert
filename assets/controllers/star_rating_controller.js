import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
  static targets = ['star', 'input']

  highlight({ currentTarget }) {
    const index = parseInt(currentTarget.dataset.index)
    this.starTargets.forEach((star, i) => {
      star.classList.toggle('text-star', i < index)
      star.classList.toggle('text-border', i >= index)
    })
  }

  reset() {
    const checked = this.inputTargets.find(i => i.checked)
    const index = checked ? parseInt(checked.value) : 0
    this.starTargets.forEach((star, i) => {
      star.classList.toggle('text-star', i < index)
      star.classList.toggle('text-border', i >= index)
    })
  }

  select({ currentTarget }) {
    const index = parseInt(currentTarget.value)
    this.starTargets.forEach((star, i) => {
      star.classList.toggle('text-star', i < index)
      star.classList.toggle('text-border', i >= index)
    })
  }
}
