import _ from "lodash";
import Popper from "popper.js";
import jQuery from "jquery";
import axios from "axios";

/**
 * jQuery + the Bootstrap jQuery plugin provide the JavaScript behind modals,
 * tabs and tooltips. Vite dedupes jquery, so Bootstrap attaches its plugins to
 * the same instance exposed on window.$.
 */
import "bootstrap";

window._ = _;
window.Popper = Popper;
window.$ = window.jQuery = jQuery;

/**
 * axios issues requests to the Laravel back-end and automatically attaches the
 * CSRF token from the page's meta tag.
 */
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

let token = document.head.querySelector("meta[name='csrf-token']");

if (token) {
	window.axios.defaults.headers.common["X-CSRF-TOKEN"] = token.content;
} else {
	console.error("CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token");
}
