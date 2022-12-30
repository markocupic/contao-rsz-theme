/**
 * Macy grid
 * Sponsoren und Gönner
 */
addEventListener('DOMContentLoaded', (event) => {

    if (typeof Macy !== 'undefined') {
        let grid_elements = document.querySelectorAll('.macy-grid-container');

        if (grid_elements) {

            let macy_options = {
                "container": null,
                trueOrder: false,
                waitForImages: false,
                margin: 16,
                columns: 4,
                breakAt: {
                    1400: 4, // bootstrap xxl
                    1200: 4, // bootstrap xl
                    992: 2, // bootstrap lg
                    768: 2, // bootstrap md
                    576: 2, // bootstrap sm
                    0: 1, // bootstrap xs
                }
            }

            for (i = 0; i < grid_elements.length; ++i) {
                macy_options['container'] = grid_elements[i];
                Macy(macy_options);
            }
        }
    }
});




