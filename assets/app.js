import $ from 'jquery';
import Swal from 'sweetalert2';
if (typeof window.jQuery === 'undefined') {
    window.$ = window.jQuery = $;
} // Assurez-vous que jQuery est globalement accessible
import './bootstrap.js';
import './bootstrap/dist/js/bootstrap.bundle.js';
import './DataTables/datatables.js';
import './DataTables/datatables.min.js';
import '@fortawesome/fontawesome-free';

import './styles/app.css';
import './bootstrap/dist/css/bootstrap.min.css';
import './DataTables/datatables.css';
import './DataTables/datatables.min.css';
import '@fortawesome/fontawesome-free/css/fontawesome.min.css';
import '@fortawesome/fontawesome-free/js/solid.min.js';
import '@fortawesome/fontawesome-free/js/brands.min.js';

import 'datatables.net';


console.log('AssetMapper configuration loaded! 🎉');
