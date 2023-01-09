import $ from 'jquery';
import BEM from 'bem.js';

export class Block {
    _blockName = '';

    block = (modifier = '') => {
        return BEM.getBEMClassName(this._blockName, '', modifier);
    };

    elem = (elem = '', modifier = '') => {
        return BEM.getBEMClassName(this._blockName, elem, modifier);
    };

    sE = (elem = '', modifier = '') => {
        return '.' + this.elem(elem, modifier)
    };

    sB = (modifier = '') => {
        return '.' + this.block(modifier)
    };

    $b = (modifier = '') => {
        return $(this.sB(modifier));
    };

    $e = (elem = '', modifier = '') => {
        return $(this.sE(elem, modifier));
    };
}