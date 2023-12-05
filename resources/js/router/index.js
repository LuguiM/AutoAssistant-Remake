import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        redirect: '/principal',
        component: () => import('../layouts/website.vue'),
        children: [
            {
                name: 'principal',
                path: 'principal',
                component: () => import('../web/ContactoCom.vue'),
            },
            {
                name: 'PilotosWeb',
                path: '/PilotosWeb',
                component: () => import('../Components/Pilotos/Pilotos.vue')
            },
            {
                name: 'servicios-mecanicosWeb',
                path: '/servicios-mecanicosWeb',
                component: () => import('../Components/ServiciosMecanicos/ServiciosPerfiles.vue')
            },
        ],
    },
    {
        path: '/IniciarSesion',
        component: () => import('../web/Login.vue')
    },
    {
        path: '/App',
        redirect: '/dashboard',
        component: () => import('../layouts/aplication.vue'),
        children: [
            {
                name: 'dashboard',
                path: '/dashboard',
                component: () => import('../web/ContactoCom.vue'),
            },
            {
                name: 'homesite',
                path: '/homesite',
                component: () => import('../web/HomeCom.vue')
            },
            {
                name: 'perfil',
                path: '/perfilUsuario',
                component: () => import('../Components/Perfil/VerPerfil.vue')
            },
            {
                name: 'Pilotos',
                path: '/Pilotos',
                component: () => import('../Components/Pilotos/Pilotos.vue')
            },
            {
                name: 'verPiloto',
                path: '/verPiloto/:id',
                component: () => import('../Components/Pilotos/VerPiloto.vue')
            },
            {
                name: 'crearPilotos',
                path: '/crearPilotos',
                component: () => import('../Components/Pilotos/CrearPiloto.vue')
            },
            {
                name: 'servicios-mecanicos',
                path: '/servicios-mecanicos',
                component: () => import('../Components/ServiciosMecanicos/ServiciosPerfiles.vue')
            },
            {
                name: 'verServicio',
                path: '/verServicio/:id',
                component: () => import('../Components/ServiciosMecanicos/verServicio.vue')
            },
            {
                name: 'inscripcionServicios',
                path: '/inscripcionServicios',
                component: () => import('../Components/ServiciosMecanicos/InscripcionServicios.vue')
            },
            {
                name: 'inscribirServicio',
                path: '/inscribirServicio',
                component: () => import('../Components/ServiciosMecanicos/InscribirServicio.vue')
            },
            {
                name: 'modificarServicio',
                path: '/modificarServicio/:id',
                component: () => import('../Components/ServiciosMecanicos/EditarServicio.vue')
            },
            {
                name: 'conductorServicios',
                path: '/serviciosContratados',
                component: () => import('../Components/Contrataciones/ConductorServicios.vue')
            },
            {
                name: 'mecanicosServicios',
                path: '/serviciosActivos',
                component: () => import('../Components/Contrataciones/MecanicoServicio.vue')
            },
            {
                name: 'verPerfilMecanico',
                path: '/perfilMecanico/:id',
                component: () => import('../Components/PerfilMecanico/verPerfil.vue')
            },
            {
                name: 'crearPerfilMecanico',
                path: '/crearPerfilMecanico',
                component: () => import('../Components/PerfilMecanico/crearPerfilMecanico.vue')
            },
            {
                name: 'manuales',
                path: '/manuales',
                component: () => import('../Components/Manuales/manuales.vue')
            }

        ]
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});

export default router;
