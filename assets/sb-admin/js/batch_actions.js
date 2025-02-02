'use strict';

window.addEventListener('load', function () {
    const batchCheckAll = document.getElementById('crudit-batch-check-all');
    const checkboxes = document.querySelectorAll('.crudit-batch-check');
    const dropdownItems = document.querySelectorAll('.crudit-batch-dropdown-item');

    let ids = [];

    // Check/uncheck all checkboxes
    // Show batch list if all checkboxes are checked
    if (batchCheckAll) {
        batchCheckAll.addEventListener('change', () => {
            checkboxes.forEach(checkbox => {
                checkbox.checked = batchCheckAll.checked;
            });

            ids = saveIds();
            showBatchList(batchCheckAll.checked);
        });
    }

    // Show batch list if at least 1 checkbox is checked
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            ids = saveIds();
            countChecked();
        });
    });

    // Modify url or request when we validate the batch action
    dropdownItems.forEach(dropdownItem => {
        dropdownItem.addEventListener('click', (event) => {
            if (dropdownItem.dataset.form) {
                let form = document.getElementById(dropdownItem.dataset.form);

                showForm(dropdownItem.dataset.form);

                form.addEventListener('submit', () => {
                    document.getElementById(form.name + '_ids').value = ids;
                });
            } else {
                event.currentTarget.href = event.currentTarget.href + '?ids=' + ids;
            }
        });
    });
});

function countChecked() {
    const batchCheckAll = document.getElementById('crudit-batch-check-all');
    const checkboxes = document.querySelectorAll('.crudit-batch-check');

    let checked = 0;

    // Count how many checkboxes are checked
    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            checked++;
        }
    });

    // Check/uncheck button batchCheckAll
    batchCheckAll.checked = (checked == checkboxes.length);

    // Show batch list if at least 1 checkbox is checked
    showBatchList((checked > 0));
}

// Show batch list
function showBatchList(showBatchList) {
    const batchList = document.querySelector('.crudit-batch-list');

    // Hide all forms
    hideForms();

    if (showBatchList) {
        batchList.classList.remove('d-none');
    } else {
        batchList.classList.add('d-none');
    }
}

// Hide all forms
function hideForms() {
    const forms = document.querySelectorAll('.batch-action-form');

    forms.forEach(form => {
        form.classList.add('d-none');
    });
}

// Show the requested form
function showForm(formId) {
    hideForms();

    document.getElementById(formId).classList.remove('d-none');
}

function saveIds() {
    const checkboxes = document.querySelectorAll('.crudit-batch-check');

    let ids = [];

    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            ids.push(checkbox.dataset.id);
        }
    });

    return ids = ids.join(',');
}