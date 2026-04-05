import { Controller } from '@hotwired/stimulus'

/**
 * Classe Carousel — gestion complète d'un carousel responsive et accessible.
 *
 * Basé sur le tutoriel Grafikart, étendu avec :
 * - effet de zoom sur la carte centrale
 * - animations directionnelles des descriptions
 * - gestion de l'accessibilité ARIA (inert, aria-current, aria-live)
 * - adaptation responsive mobile/desktop
 * - protection contre le double-clic (isAnimating)
 */
class Carousel {
  /**
   * @param {HTMLElement} element           - Élément racine contenant les slides
   * @param {Object}      [options]         - Options de configuration
   * @param {number}      [options.slidesToScroll=1]      - Nombre de slides à faire défiler à chaque navigation
   * @param {number}      [options.slidesVisible=1]       - Nombre de slides visibles simultanément
   * @param {boolean}     [options.loop=false]            - Boucle simple (retour au début en fin de liste)
   * @param {boolean}     [options.infinite=false]        - Boucle infinie par clonage des slides
   * @param {boolean}     [options.navigation=true]       - Affiche les boutons précédent / suivant
   * @param {boolean}     [options.pagination=false]      - Affiche les points de pagination
   * @param {number}      [options.transitionDuration=500]- Durée de la transition en millisecondes
   */
  constructor(element, options = {}) {
    this.element = element;
    // Object.assign fusionne les options par défaut avec celles passées en paramètre
    this.options = Object.assign(
      {},
      {
        slidesToScroll: 1,
        slidesVisible: 1,
        loop: false,
        pagination: false,
        navigation: true,
        infinite: false,
        transitionDuration: 500,
      },
      options
    );
    if (this.options.loop && this.options.infinite) {
      throw new Error("un carousel ne peut etre a la fois en boucle et en infini");
    }
    let children = Array.from(element.children);
    this.isMobile = false;
    this.currentItem = 0;
    this.moveCallbacks = [];
    this.offset = 0;
    this.isAnimating = false;

    // Construction du DOM : on enveloppe chaque enfant dans un carousel__item
    this.root = this.createDivWithClass("carousel");
    this.container = this.createDivWithClass("carousel__wrapper");
    this.root.appendChild(this.container);
    this.element.appendChild(this.root);
    this.items = children.map((child, index) => {
      let item = this.createDivWithClass("carousel__item");
      item.appendChild(child);
      item.setAttribute("role", "group");
      item.setAttribute("aria-roledescription", "slide");
      item.setAttribute("aria-label", `Étape ${index + 1} sur ${children.length}`);
      return item;
    });

    // Mode infini : on clone les premiers et derniers éléments pour simuler une boucle sans saut
    if (this.options.infinite) {
      this.offset = this.options.slidesVisible + this.options.slidesToScroll;
      if (this.offset > children.length) {
        console.error("erreur pas assez d'element dans le carousel", element);
      }
      this.items = [
        ...this.items.slice(this.items.length - this.offset).map((item) => item.cloneNode(true)),
        ...this.items,
        ...this.items.slice(0, this.offset).map((item) => item.cloneNode(true)),
      ];
      this.gotoItem(this.offset, false);
    }

    this.items.forEach((item) => this.container.appendChild(item));
    this.onWindowResize();
    this.zoom();

    if (this.options.navigation) {
      this.createNavigation();
    }

    if (this.options.pagination === true) {
      this.createPagination();
    }

    // Masque les slides hors champ (opacité 0 + pointer-events none)
    this.onMove((index) => {
      this.items.forEach((item, i) => {
        if (i >= index && i < index + this.slidesVisible) {
          item.style.opacity = "1";
          item.style.pointerEvents = "auto";
        } else {
          item.style.opacity = "0";
          item.style.pointerEvents = "none";
        }
      });
    });
    this.moveCallbacks.forEach((cb) => cb(this.currentItem));

    // Stocké pour pouvoir retirer l'écouteur dans destroy()
    this._onResize = this.onWindowResize.bind(this);
    window.addEventListener("resize", this._onResize);

    // Navigation clavier : flèches gauche/droite depuis n'importe quel élément du carousel
    this.root.addEventListener("keyup", (e) => {
      if (e.key === "ArrowRight" || e.key === "Right") {
        this.next();
      } else if (e.key === "ArrowLeft" || e.key === "Left") {
        this.prev();
      }
    });

    // Repositionnement silencieux après la fin de la transition (mode infini)
    this._onTransitionEnd = (e) => {
      if (e.target !== this.container) return;
      this.isAnimating = false;
      if (this.options.infinite) {
        this.resetInfinite();
      }
    };
    this.container.addEventListener("transitionend", this._onTransitionEnd);
  }

  /**
   * Calcule et applique les largeurs du conteneur et de chaque slide.
   * Appelé au chargement et à chaque changement de breakpoint.
   */
  setStyle() {
    let ratio = this.items.length / this.slidesVisible;
    this.container.style.width = ratio * 100 + "%";
    this.container.style.transition = "none";
    this.items.forEach((item) => {
      item.style.transition = "none";
      item.style.width = 100 / this.slidesVisible / ratio + "%";
    });
    this.zoom(false);
    this.updateAccessibility(this.currentItem);
  }

  /**
   * Crée et insère les boutons de navigation précédent / suivant.
   * En mode loop, les boutons sont toujours visibles.
   * En mode normal, ils se masquent aux extrémités de la liste.
   */
  createNavigation() {
    let prevButton = document.createElement("button");
    prevButton.setAttribute("class", "carousel__prev");
    prevButton.setAttribute("aria-label", "étape précédente");
    prevButton.setAttribute("type", "button");
    prevButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>';
    let nextButton = document.createElement("button");
    nextButton.setAttribute("class", "carousel__next");
    nextButton.setAttribute("aria-label", "étape suivante");
    nextButton.setAttribute("type", "button");
    nextButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>';
    this.root.appendChild(prevButton);
    this.root.appendChild(nextButton);

    nextButton.addEventListener("click", this.next.bind(this));
    prevButton.addEventListener("click", this.prev.bind(this));
    if (this.options.loop === true) {
      return;
    }
    // Masque le bouton précédent en début de liste, suivant en fin de liste
    this.onMove((index) => {
      if (index === 0) {
        prevButton.classList.add("carousel__prev--hidden");
      } else {
        prevButton.classList.remove("carousel__prev--hidden");
      }
      if (this.items[this.currentItem + this.slidesVisible] === undefined) {
        nextButton.classList.add("carousel__next--hidden");
      } else {
        nextButton.classList.remove("carousel__next--hidden");
      }
    });
    this.root.appendChild(prevButton);
    this.root.appendChild(this.container);
    this.root.appendChild(nextButton);
  }

  /**
   * Crée les points de pagination cliquables.
   * Chaque point correspond à un groupe de slides (selon slidesToScroll).
   */
  createPagination() {
    let pagination = this.createDivWithClass("carousel__pagination");
    let buttons = [];
    this.root.appendChild(pagination);
    for (let i = 0; i < this.items.length - 2 * this.offset; i = i + this.options.slidesToScroll) {
      let button = this.createDivWithClass("carousel__pagination__button");
      button.addEventListener("click", () => this.gotoItem(i + this.offset));
      pagination.appendChild(button);
      buttons.push(button);
    }
    this.onMove((index) => {
      let count = this.items.length - 2 * this.offset;
      let activeButton = buttons[Math.floor(((index - this.offset) % count) / this.options.slidesToScroll)];
      if (activeButton) {
        buttons.forEach((button) => button.classList.remove("carousel__pagination__button--active"));
        activeButton.classList.add("carousel__pagination__button--active");
      }
    });
  }

  /**
   * Avance d'un groupe de slides vers la droite.
   * Bloqué pendant une animation en cours (isAnimating).
   */
  next() {
    if (this.isAnimating) return;
    this.isAnimating = true;
    this.gotoItem(this.currentItem + this.slidesToScroll);
    // Filet de sécurité : libère le verrou si transitionend ne se déclenche pas (ex: onglet inactif)
    setTimeout(() => {
      this.isAnimating = false;
    }, this.options.transitionDuration);
  }

  /**
   * Recule d'un groupe de slides vers la gauche.
   * Bloqué pendant une animation en cours (isAnimating).
   */
  prev() {
    if (this.isAnimating) return;
    this.isAnimating = true;
    this.gotoItem(this.currentItem - this.slidesToScroll);
    setTimeout(() => {
      this.isAnimating = false;
    }, this.options.transitionDuration);
  }

  /**
   * Déplace le carousel vers la slide à l'index donné.
   *
   * @param {number}  index               - Index de la slide cible
   * @param {boolean} [animation=true]    - Si false, le déplacement est instantané (sans transition CSS)
   */
  gotoItem(index, animation = true) {
    if (index < 0) {
      if (this.options.loop) {
        index = this.items.length - this.slidesVisible;
      } else {
        return;
      }
    } else if (index >= this.items.length || (this.items[this.currentItem + this.slidesVisible] === undefined && index > this.currentItem)) {
      if (this.options.loop) {
        index = 0;
      } else {
        return;
      }
    }

    // Désactive les transitions CSS pour un repositionnement instantané
    if (animation === false) {
      this.container.style.transition = "none";
      this.items.forEach((item) => {
        item.style.transition = "none";
        const desc = item.querySelector(".carousel-card-description");
        if (desc) desc.style.transition = "none";
      });
    }
    let direction = index > this.currentItem ? 1 : -1;
    let translateX = (index * -100) / this.items.length;
    this.container.style.transform = `translate3d(${translateX}%, 0, 0)`;
    this.currentItem = index;

    this.moveCallbacks.forEach((cb) => cb(index));
    this.zoom(animation, direction);
    this.container.offsetHeight; // Force un reflow pour que les transitions se déclenchent après la remise à zéro
    this.updateAccessibility(this.currentItem);

    // Réactive les transitions CSS après le repositionnement instantané
    if (animation === false) {
      this.items.forEach((item) => {
        item.style.transition = "";
        const desc = item.querySelector(".carousel-card-description");
        if (desc) desc.style.transition = "";
      });
      this.container.style.transition = `transform ${this.options.transitionDuration}ms ease-in-out`;
    }
  }

  /**
   * Applique le zoom sur la carte centrale et masque les descriptions des autres cartes.
   *
   * @param {boolean} [animate=true]  - Si false, pas de transition (initialisation ou resize)
   * @param {number}  [direction=1]   - Sens du déplacement : 1 = droite, -1 = gauche
   */
  zoom(animate = true, direction = 1) {
    this.items.forEach((item) => {
      item.classList.remove("carousel__item--zoom");
      const desc = item.querySelector(".carousel-card-description");
      if (desc) {
        if (animate) {
          // Le texte sortant glisse dans la direction du mouvement et disparaît
          desc.style.transition = "opacity 0.5s ease, transform 0.5s ease";
          desc.style.opacity = "0";
          desc.style.transform = `translateX(${-direction * 30}px)`;
        } else {
          desc.style.transition = "none";
          desc.style.opacity = "0";
          desc.style.transform = "translateX(0)";
        }
      }
    });
    if (this.slidesVisible >= 3) {
      const middleIndex = this.currentItem + Math.floor(this.slidesVisible / 2);
      const middleItem = this.items[middleIndex];
      if (middleItem) {
        middleItem.classList.add("carousel__item--zoom");
        this.showDescription(middleItem, animate, direction);
      }
    } else {
      let current = this.items[this.currentItem];
      if (current) {
        this.showDescription(current, animate, direction);
      }
    }
  }

  /**
   * Anime l'apparition de la description de la carte active.
   * Le texte entre depuis le côté d'arrivée (même direction que le déplacement).
   *
   * @param {HTMLElement} item            - Carte dont la description doit apparaître
   * @param {boolean}     [animate=true]  - Si false, affichage instantané
   * @param {number}      [direction=1]   - Sens du déplacement : 1 = droite, -1 = gauche
   */
  showDescription(item, animate = true, direction = 1) {
    const desc = item.querySelector(".carousel-card-description");
    if (!desc) return;
    if (animate) {
      // Place le texte hors-champ côté arrivée, puis le fait glisser vers sa position finale
      desc.style.transition = "none";
      desc.style.opacity = "0";
      desc.style.transform = `translateX(${direction * 30}px)`;
      desc.offsetHeight; // Force un reflow pour que la transition de départ soit prise en compte
      desc.style.transition = "opacity 0.5s ease, transform 0.5s ease";
      desc.style.opacity = "1";
      desc.style.transform = "translateX(0)";
    } else {
      desc.style.transition = "none";
      desc.style.opacity = "1";
      desc.style.transform = "translateX(0)";
    }
  }

  /**
   * Met à jour les attributs d'accessibilité sur chaque slide.
   * La slide active reçoit aria-current="true", les autres sont rendues inertes.
   * Met également à jour le texte de la zone aria-live pour les lecteurs d'écran.
   *
   * @param {number}  index             - Index de la slide courante
   * @param {boolean} [setFocus=false]  - Si true, déplace le focus clavier sur la slide active
   */
  updateAccessibility(index, setFocus = false) {
    let middleIndex;
    if (this.slidesVisible >= 3) {
      middleIndex = index + Math.floor(this.slidesVisible / 2);
    } else {
      middleIndex = index;
    }

    this.items.forEach((item, i) => {
      const isActive = i === middleIndex;
      // inert désactive tout le contenu interactif (focus, tab, événements) en une seule propriété
      item.inert = !isActive;
      if (isActive) {
        item.setAttribute("aria-current", "true");
      } else {
        item.removeAttribute("aria-current");
      }
    });
    if (setFocus && (document.activeElement === document.body || this.root.contains(document.activeElement))) {
      this.items[middleIndex].focus({ preventScroll: true });
    }
    // Met à jour l'annonce vocale du numéro de slide courant
    let status = document.getElementById("carousel-status");
    if (status) {
      let visibleSlideNumber;
      if (this.options.infinite) {
        visibleSlideNumber = ((middleIndex - this.offset + this.items.length) % (this.items.length - 2 * this.offset)) + 1;
      } else {
        visibleSlideNumber = middleIndex + 1;
      }
      status.textContent = `Étape ${visibleSlideNumber} sur ${this.items.length - (this.options.infinite ? 2 * this.offset : 0)}`;
    }
  }

  /**
   * Repositionne silencieusement le carousel après une transition infinie.
   * Quand on dépasse un clone, on saute sur le vrai élément correspondant sans animation.
   */
  resetInfinite() {
    if (this.currentItem <= this.options.slidesToScroll) {
      this.gotoItem(this.currentItem + this.items.length - 2 * this.offset, false);
    } else if (this.currentItem >= this.items.length - this.offset) {
      this.gotoItem(this.currentItem - (this.items.length - 2 * this.offset), false);
    }
  }

  /**
   * Enregistre un callback appelé à chaque déplacement du carousel.
   *
   * @param {Function} cb - Fonction appelée avec l'index courant en paramètre
   */
  onMove(cb) {
    this.moveCallbacks.push(cb);
  }

  /**
   * Gère le changement de breakpoint mobile/desktop.
   * Recale la carte active pour qu'elle reste visible après le changement.
   */
  onWindowResize() {
    let mobile = window.innerWidth < 1024;
    if (mobile !== this.isMobile) {
      // Desktop → Mobile : se caler sur la carte qui était au centre
      if (mobile && this.options.slidesVisible >= 3) {
        this.currentItem = this.currentItem + Math.floor(this.options.slidesVisible / 2);
      }
      // Mobile → Desktop : reculer pour que la carte courante revienne au centre
      if (!mobile && this.options.slidesVisible >= 3) {
        this.currentItem = Math.max(0, this.currentItem - Math.floor(this.options.slidesVisible / 2));
      }
      this.isMobile = mobile;
      this.setStyle();
      this.gotoItem(this.currentItem, false);
    } else if (!mobile) {
      this.isMobile = false;
      this.setStyle();
      this.gotoItem(this.currentItem, false);
    }
    this.moveCallbacks.forEach((cb) => cb(this.currentItem));
  }

  /**
   * Crée un élément div avec la classe CSS donnée.
   *
   * @param {string}      className - Classe CSS à appliquer
   * @returns {HTMLElement}
   */
  createDivWithClass(className) {
    let div = document.createElement("div");
    div.setAttribute("class", className);
    return div;
  }

  /**
   * Nombre de slides à faire défiler — toujours 1 sur mobile.
   * @returns {number}
   */
  get slidesToScroll() {
    return this.isMobile ? 1 : this.options.slidesToScroll;
  }

  /**
   * Nombre de slides visibles — toujours 1 sur mobile.
   * @returns {number}
   */
  get slidesVisible() {
    return this.isMobile ? 1 : this.options.slidesVisible;
  }

  /**
   * Supprime les écouteurs d'événements globaux.
   * Appelé par Stimulus lors de la déconnexion du controller.
   */
  destroy() {
    window.removeEventListener("resize", this._onResize);
    this.container.removeEventListener("transitionend", this._onTransitionEnd);
  }
}

/**
 * Controller Stimulus — instancie et détruit la classe Carousel
 * en suivant le cycle de vie du composant Stimulus (connect / disconnect).
 */
export default class extends Controller {
  connect() {
    this.carousel = new Carousel(this.element, {
      slidesVisible: 3,
      slidesToScroll: 1,
      infinite: true,
      pagination: false,
      transitionDuration: 800,
    })
  }

  disconnect() {
    this.carousel.destroy()
  }
}
