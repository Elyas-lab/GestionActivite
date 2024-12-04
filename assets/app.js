import $ from 'jquery';
import Swal from 'sweetalert2';
if (typeof window.jQuery === 'undefined') {
    window.$ = window.jQuery = $;
} // Assurez-vous que jQuery est globalement accessible
import './bootstrap.js';
import './bootstrap/dist/js/bootstrap.bundle.js';
import './DataTables/datatables.js';
import './DataTables/datatables.min.js';

import './styles/app.css';
import './bootstrap/dist/css/bootstrap.min.css';
import './DataTables/datatables.css';
import './DataTables/datatables.min.css';

import 'datatables.net';


console.log('AssetMapper configuration loaded! 🎉');
