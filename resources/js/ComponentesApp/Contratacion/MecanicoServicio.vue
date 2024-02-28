<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Servicios Activos</h3>
        </div>

        <v-card class="busquedaStyle mb-5">
            <v-card-Text>
                <v-form>
                    <v-row>
                        <v-col cols="12" md="6">
                                <v-select
                                    prepend-inner-icon="mdi-car-search"
                                    label="Estado"
                                    :items="[ 'Activo', 'En espera', 'Cancelado', 'Completado']"
                                    variant="solo"
                                    hide-details="auto"
                                ></v-select>
                        </v-col>
                        <v-col cols="12" md="5" class="d-flex flex-column flex-sm-row align-center justify-center justify-md-start" style="gap:10px;">
                            <v-btn  prepend-icon="mdi-magnify" class="blueButton px-8">
                                Buscar
                            </v-btn>
                            <v-btn prepend-icon="mdi-trash-can" class="greyButton px-8">
                                Limpiar
                            </v-btn>
                        </v-col>
                    </v-row>


                </v-form>
            </v-card-Text>
        </v-card>

        
        <v-tabs v-model="tab" color="blue" bg-color="transparent" align-tabs="start">
            <v-tab value="card">
                <v-icon>mdi-view-grid-outline</v-icon>
            </v-tab>
            <v-tab value="table">
                <v-icon>mdi-table</v-icon>
            </v-tab>
        </v-tabs>

        <v-window v-model="tab">
            <v-window-item value="card">
                <v-container fluid>
                    <v-row v-if="loading" v-model="loading" class="fill-height" align-content="center" justify="center">
                        <v-col class="text-subtitle-1 text-center" cols="12">
                            Cargando contrataciones
                        </v-col>
                        <v-col cols="6">
                            <v-progress-linear indeterminate rounded height="6"></v-progress-linear>
                        </v-col>
                    </v-row>

                    <v-alert v-else-if="!status" color="error" icon="$error" :text="'No se encontraron contrataciones' || message">
                    </v-alert>

                    <v-row v-else-if="status">
                        <v-col cols="12" sm="6" v-for="(servicio, index) in servicios" :key="index">
                            <v-card class="bg-secondary">
                                <v-card-text>
                                    <v-row align="center">
                                        <v-col cols="12" sm="4">
                                            <v-img :src="servicio.servicio.logo" max-height="200"></v-img>
                                        </v-col>
                                        <v-col cols="12" sm="8">
                                            <v-card-title class="text-h5 font-weight-bold item-texto">
                                                {{ servicio.servicio.servicio }}
                                            </v-card-title>
                                            <v-card-subtitle class="item-texto">
                                                Fecha de contratación: {{ servicio.fecha_contratacion }}
                                            </v-card-subtitle>
                                            <v-card-text>
                                                Estado:
                                                <v-chip variant="elevated" :color="servicio.estado.color" class="ma-2" :prepend-icon="servicio.estado.icon">
                                                    {{servicio.estado.estado}}
                                                </v-chip>
                                            </v-card-text>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                                <v-card-actions class="d-flex flex-column flex-sm-row justify-space-between gap-10"  v-if="servicio.estado.estado === 'Activo'">
                                    <v-btn class="bg-grey2" prepend-icon="mdi-message-outline">Chat</v-btn>
                                </v-card-actions>
                                <v-card-actions class="d-flex flex-column flex-sm-row justify-space-between gap-10"  v-else-if="servicio.estado.estado === 'En espera'">
                                    <div class="d-flex flex-column flex-md-row gap-10" >
                                        <AceptarServicio type="text"></AceptarServicio>
                                        <CancelarRechazar title="Rechazar" type="text"></CancelarRechazar>                                    
                                    </div>
                                    <Observacion title="Crear" type="text"></Observacion>

                                </v-card-actions>

                                <v-card-actions class="d-flex justify-space-between" v-else-if="servicio.estado.estado === 'Rechazado'">
                                    <div class="d-flex flex-column flex-sm-row gap-10" >
                                        <VerRechazo type="text"></VerRechazo>
                                    </div>
                                </v-card-actions>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-container>
            </v-window-item>
            <v-window-item value="table">
                <v-container fluid>
                    <v-data-table v-model:page="page"
                    :headers="headers"
                    :items="servicios"
                    :items-per-page="itemsPerPage"
                    :loading="loading" loading-text="Cargando contrataciones" no-data-text="No se encontraron contrataciones">

                        <template v-slot:item.servicio.logo="{ item }">
                            <v-card class="my-2" elevation="2" rounded>
                            <v-img
                                :src="item.servicio.logo"
                                height="64"
                                cover
                            ></v-img>
                            </v-card>
                        </template>

                        <template v-slot:item.estado="{ item }">
                            <v-chip
                                :color="item.estado.color"
                                class="text-uppercase"
                                label
                                size="small"
                                :prepend-icon="item.estado.icon"
                            >
                            {{item.estado.estado}}
                            </v-chip>
                        </template>
                        <template v-slot:item.acciones="{ item }">
                            <div v-if="item.estado.estado === 'Activo'">                               
                                <v-btn variant="flat" density="compact" icon="mdi-message-outline"></v-btn>
                            </div>

                            <div v-else-if="item.estado.estado === 'En espera'">
                                <AceptarServicio type="icon"></AceptarServicio>
                                <CancelarRechazar title="Rechazar" type="icon"></CancelarRechazar>                                    
                                <Observacion title="Crear" type="icon"></Observacion>
                            </div>

                            <div v-else-if="item.estado.estado === 'Rechazado'">
                                <VerRechazo type="icon"></VerRechazo>
                            </div>
                        </template>

                        <template v-slot:bottom>
                            <div class="text-center pt-2">
                                <v-pagination
                                v-model="page"
                                :length="pageCount"
                                ></v-pagination>
                            </div>
                        </template>
                        
                    </v-data-table>
                </v-container>
            </v-window-item>
        </v-window>

        
    </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AceptarServicio from '../../Components/Modales/AceptarServicio.vue';
import Observacion from '../../Components/Modales/Observacion.vue';
import VerRechazo from '../../Components/Modales/VerRechazo.vue';
import CancelarRechazar from '../../Components/Modales/CancelarRechazar.vue';
import notify from '@/plugins/notify.js';
import { getData, postData } from '@/plugins/api.js';
import { useAuthStore } from '@/Stores/auth';

const authStore = useAuthStore();
const tab = ref('table');

const page = ref(1);
const itemsPerPage = ref(3);

const headers = ref([
    {title:'Imagen', value:'servicio.logo'},
    {title:'Servicio', value:'servicio.servicio'},
    {title:'Fecha de contratación', value:'fecha_contratacion'},
    {title:'Estado', value:'estado'},
    {title:'Acciones', value:'acciones'}
])

const servicios = ref([])
const loading = ref(true);
const status = ref(false);
const message = ref('');

const pageCount = Math.ceil(servicios.value.length / itemsPerPage.value);

const getPerfil = async () => {
    try {
        const id = authStore.authUser.id;
        const data = await getData(('verificarPerfil/' + id));

        if (!data.status) {
            notify('No se encontro perfil mecanico', 'info')
            setTimeout(() => router.push({ path: 'perfilMecanico' }), 3000)
        }

        getContrataciones(data.id);
        
    } catch (error) {
        notify(error.message, 'error');
    } 
};

const getContrataciones = async (id) => {
    try {
        const data = await getData(('contrataciones/' + id));
        status.value = data.status;
        servicios.value = data.data;
        console.log('data', servicios.value);

        if (!data.status) {
            status.value = data.status;
            message.value = data.message;
        }
    } catch (error) {
        notify(error.message, 'error');
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    getPerfil();
})
</script>

<style>
.v-card-actions .v-btn ~ .v-btn:not(.v-btn-toggle .v-btn) {
    margin-inline-start: 0 !important; 
}

.v-table__wrapper thead{
    background-color: #1279C1;
    color: #FFFFFF;
}
</style>