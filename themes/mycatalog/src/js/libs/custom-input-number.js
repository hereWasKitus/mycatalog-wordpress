/**
 * Custom input number
 */
// (function () {

//   if (document.querySelector('input[type="number"]') === null) return;

//   const InputNumber = function( el ) {
//     this.root = el;
//   }

//   InputNumber.prototype = {
//     render () {
//       const wrapper = document.createElement('div');
//       wrapper.classList.add('custom-input-number-container');

//       const btnUp = document.createElement('div');
//       btnUp.classList.add('custom-input-number__up');
//       btnUp.textContent = '+';
//       btnUp.addEventListener('click', this.set(1));

//       const btnDown = document.createElement('div');
//       btnDown.classList.add('custom-input-number__down');
//       btnDown.textContent = '-';
//       btnUp.addEventListener('click', this.set(-1));
//     },

//     set ( num ) {
//       this.root.value += num;
//     }
//   }
// })();