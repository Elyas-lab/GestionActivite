import $ from 'jquery';
if (typeof window.jQuery === 'undefined') {
    window.$ = window.jQuery = $;
} // Assurez-vous que jQuery est globalement accessible
import './bootstrap.js';
import './bootstrap-5-dist/js/bootstrap.bundle.js';
import './DataTables/datatables.js';
import './DataTables/datatables.min.js';

import './styles/app.css';
import './bootstrap-5-dist/css/bootstrap.min.css';
import './DataTables/datatables.css';

import 'datatables.net';


console.log('AssetMapper configuration loaded! 🎉');
