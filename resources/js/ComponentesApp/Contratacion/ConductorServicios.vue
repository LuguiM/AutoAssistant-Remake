<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Servicios Contratados</h3>
        </div>

        <v-card class="busquedaStyle mb-5">
            <v-card-Text>
                <v-form>
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-select prepend-inner-icon="mdi-car-search" label="Estado"
                                :items="['Activo', 'En espera', 'Cancelado', 'Completado']" variant="solo"
                                hide-details="auto"></v-select>
                        </v-col>
                        <v-col cols="12" md="5"
                            class="d-flex flex-column flex-sm-row align-center justify-center justify-md-start"
                            style="gap:10px;">
                            <v-btn prepend-icon="mdi-magnify" class="blueButton px-8">
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
                                    <v-chip variant="elevated" :color="servicio.estado.color" class="ma-2"
                                        :prepend-icon="servicio.estado.icon">
                                        {{ servicio.estado.estado }}
                                    </v-chip>
                                </v-card-text>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions class="d-flex flex-column flex-sm-row justify-space-between gap-10"
                        v-if="servicio.estado.estado === 'Activo'">
                        <div class="d-flex flex-column flex-md-row gap-10">
                            <CancelarRechazar title="Cancelar" type="text" :id="servicio.id" @actualizar="getContrataciones(authStore.user.id)"></CancelarRechazar>
                        </div>

                        <v-btn class="bg-grey2" prepend-icon="mdi-message-outline">Chat</v-btn>
                    </v-card-actions>
                    <v-card-actions class="d-flex flex-column flex-sm-row justify-space-between gap-10"
                        v-else-if="servicio.estado.estado === 'En espera'">
                        <div class="d-flex flex-column flex-md-row gap-10">
                            <v-btn class="bg-primary" prepend-icon="mdi-square-edit-outline">Modificar</v-btn>
                            <CancelarRechazar title="Cancelar" type="text" :id="servicio.id"></CancelarRechazar>
                        </div>

                        <Observacion title="Ver" type="text"></Observacion>
                    </v-card-actions>

                    <v-card-actions class="d-flex justify-space-between" v-else-if="servicio.estado.estado === 'Rechazado'">
                        <div class="d-flex flex-column flex-sm-row gap-10">
                            <VerRechazo type="text"></VerRechazo>
                        </div>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>

    </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Observacion from '../../Components/Modales/Observacion.vue';
import VerRechazo from '../../Components/Modales/VerRechazo.vue';
import CancelarRechazar from '../../Components/Modales/CancelarRechazar.vue';
import notify from '@/plugins/notify.js';
import { getData, postData } from '@/plugins/api.js';
import { useAuthStore } from '@/Stores/auth';

const authStore = useAuthStore();


const servicios = ref([]);
const loading = ref(true);
const status = ref(false);
const message = ref('');

const getContrataciones = async (id) => {
    try {
        const data = await getData(('contrataciones/' + id));
        status.value = data.status;
        servicios.value = data.data.data;
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
    getContrataciones(authStore.user.id);
})

</script>

<style>
.v-card-actions .v-btn~.v-btn:not(.v-btn-toggle .v-btn) {
    margin-inline-start: 0 !important;
}

.v-table__wrapper thead {
    background-color: #1279C1;
    color: #FFFFFF;
}
</style>