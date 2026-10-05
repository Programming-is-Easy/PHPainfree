document.addEventListener('DOMContentLoaded', () => {
	console.log(
		'PHPainfree loaded!',
		'This script is in /js/phpainfree.js and can be deleted.'
	);
});

/**
 * This function is a short-cut to document.getElementById().
 *
 * @param string element_id 
 * @return HTMLElement element 
 */
function getEl(element_id) {
	return document.getElementById(element_id);
}

/**
 * This function is a short-cut to document.querySelectorAll().
 *
 * @param string selector 
 * @return HTMLElement[] elements 
 */
function getSel(selector) {
	return document.querySelectorAll(selector);
}

/**
 * This function is a short-cut to document.querySelector().
 *
 * @param string selector 
 * @return HTMLElement element 
 */
function oneSel(selector) {
	return document.querySelector(selector);
}

/**
 * This simple function allows us to remove the "active" class on any 
 * nav-item element and set it on the element that has been clicked. 
 *
 * @param HTMLElement active_element 
 * @return void 
 */
function set_active(element) {
	const parent_el = element.parentElement;
	if ( parent_el && parent_el.children ) {
		for ( let i = 0; i < parent_el.children.length; ++i ) {
			if ( parent_el.children[i] !== element ) {
				parent_el.children[i].classList.remove('active');
			} else {
				parent_el.children[i].classList.add('active');
			}
		}
	}
}
