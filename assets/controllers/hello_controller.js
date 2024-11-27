import { Controller } from '@hotwired/stimulus';

const MULTIPLIERS = {
    'px-pt': 3/4,
    'pt-px': 4/3,
    'px-in': 1/96,
    'pt-in': 1/72,
};

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    static targets = ['direction', 'quantity', 'result']

    convert() {
        this.resultTarget.innerText = MULTIPLIERS[this.directionTarget.value] * this.quantityTarget.value;
    }
}
