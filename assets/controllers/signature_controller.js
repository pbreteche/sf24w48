import {Controller} from "@hotwired/stimulus";
import SignaturePad from 'signature_pad';
export default class extends Controller {
    static targets = ['canvas', 'button', 'output'];
    connect() {
        this.signaturePad = new SignaturePad(this.canvasTarget);
        // endStroke is SignaturePad event, not DOM...
        this.signaturePad.addEventListener('endStroke', () => {
            const totalPoints = this.signaturePad.toData().reduce((prev, stroke) => prev + stroke.points.length, 0);
            this.buttonTarget.disabled = 20 > totalPoints;
        })
    }
    clear() {
        this.signaturePad.clear();
    }

    print() {
        this.outputTarget.innerHTML = `<img src="${this.signaturePad.toDataURL()}">`;

    }
}
