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
                component: () => import('../ComponentesApp/Pilotos/Pilotos.vue')
            },
            {
                name: 'servicios-mecanicosWeb',
                path: '/servicios-mecanicosWeb',
                component: () => import('../ComponentesApp/ServiciosMecanicos/ServiciosPerfiles.vue')
            },
        ],
    },
    {
        path: '/IniciarSesion',
        component: () => import('../web/Login.vue')
    },
    {
        path: '/OpcionesRegistro',
        component: () => import('../web/Registro/OpcionesRegistro.vue')
    },
    {
        path: '/RegistroMecanicos',
        component: () => import('../web/Registro/RegistroMecanico.vue')
    },
    {
        path: '/RegistroConductores',
        component: () => import('../web/Registro/RegistroConductor.vue')
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
                component: () => import('../ComponentesApp/Perfil/VerPerfil.vue')
            },
            {
                name: 'Pilotos',
                path: '/Pilotos',
                component: () => import('../ComponentesApp/Pilotos/Pilotos.vue')
            },
            {
                name: 'verPiloto',
                path: '/verPiloto/:id',
                component: () => import('../ComponentesApp/Pilotos/VerPiloto.vue')
            },
            {
                name: 'crearPilotos',
                path: '/crearPilotos',
                component: () => import('../ComponentesApp/Pilotos/CrearPiloto.vue')
            },
            {
                name: 'servicios-mecanicos',
                path: '/servicios-mecanicos',
                component: () => import('../ComponentesApp/ServiciosMecanicos/ServiciosPerfiles.vue')
            },
            {
                name: 'verServicio',
                path: '/verServicio/:id',
                component: () => import('../ComponentesApp/ServiciosMecanicos/verServicio.vue')
            },
            {
                name: 'inscripcionServicios',
                path: '/inscripcionServicios',
                component: () => import('../ComponentesApp/ServiciosMecanicos/InscripcionServicios.vue')
            },
            {
                name: 'inscribirServicio',
                path: '/inscribirServicio',
                component: () => import('../ComponentesApp/ServiciosMecanicos/InscribirServicio.vue')
            },
            {
                name: 'modificarServicio',
                path: '/modificarServicio/:id',
                component: () => import('../ComponentesApp/ServiciosMecanicos/EditarServicio.vue')
            },
            {
                name: 'conductorServicios',
                path: '/serviciosContratados',
                component: () => import('../ComponentesApp/Contratacion/ConductorServicios.vue')
            },
            {
                name: 'mecanicosServicios',
                path: '/serviciosActivos',
                component: () => import('../ComponentesApp/Contratacion/MecanicoServicio.vue')
            },
            {
                name: 'verPerfilMecanico',
                path: '/perfilMecanico/:id',
                component: () => import('../ComponentesApp/PerfilMecanico/verPerfil.vue')
            },
            {
                name: 'crearPerfilMecanico',
                path: '/crearPerfilMecanico',
                component: () => import('../ComponentesApp/PerfilMecanico/crearPerfilMecanico.vue')
            },
            {
                name: 'manuales',
                path: '/manuales',
                component: () => import('../ComponentesApp/Manuales/manuales.vue')
            }

        ]
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});

export default router;
