/**
 * Custom select
 */
(function () {

  if (document.querySelector('.custom-select') === null) return;

  function customSelect(el) {
    const root = el;
    const wrapper = document.createElement('div');

    function toggleList () {
      wrapper.classList.toggle('is-active');
    }

    function render () {
      wrapper.classList.add('custom-select-container');

      var selected = document.createElement('span');
      selected.classList.add('custom-select-selected');

      var list = document.createElement('ul');
      list.classList.add('custom-select-list');

      root.querySelectorAll('option').forEach((option, index) => {
        var list_item = document.createElement('li');
        list_item.classList.add('custom-select-list__item');
        list_item.textContent = option.textContent;
        list_item.dataset.value = option.value;
        list_item.dataset.index = index;

        if (index == root.selectedIndex) {
          list_item.classList.add('is-active');
          selected.textContent = list_item.textContent;
        }

        list_item.addEventListener('click', select.bind(this, list_item.dataset.index));
        list.appendChild(list_item);
      });

      root.after(wrapper);
      wrapper.appendChild(root);
      wrapper.appendChild(selected);
      wrapper.appendChild(list);

      wrapper.addEventListener('click', toggleList);
    }

    function select (index) {
      root.selectedIndex = index;

      wrapper.querySelector('.custom-select-selected').textContent = wrapper.querySelectorAll('.custom-select-list__item')[index].textContent;
      wrapper.querySelector('.is-active').classList.remove('is-active');
      wrapper.querySelectorAll('.custom-select-list li')[index].classList.add('is-active');
    }

    render();
  };

  document.querySelectorAll('.custom-select').forEach(el => customSelect(el));
})();