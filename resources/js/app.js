import './bootstrap';

import AOS from 'aos';
import 'aos/dist/aos.css'; // Importe também o arquivo CSS do AOS
AOS.init();

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import { TabulatorFull as Tabulator } from 'tabulator-tables';
window.Tabulator = Tabulator;

import IMask from 'imask';
window.IMask = IMask;

import Swal from 'sweetalert2';
window.Swal = Swal;