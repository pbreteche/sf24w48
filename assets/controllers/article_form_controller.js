import { Controller } from '@hotwired/stimulus';
import { getComponent } from '@symfony/ux-live-component';

export default class extends Controller {
    static targets = ['title', 'body']

    async initialize() {
        this.component = await getComponent(this.element);
        this.component.on('render:finished', () => {
            this.update();
        });
    }

    update() {
        if (this.titleTarget.value && !this.bodyTarget.value) {
            this.bodyTarget.value = this.titleTarget.value;
        }
    }

    stateChanged() {
        this.component.render();
    }
}
