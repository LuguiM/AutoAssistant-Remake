<template>
    <v-container>
        <v-row  v-if="loading" v-model="loading" class="fill-height" align-content="center" justify="center">
            <v-col class="text-subtitle-1 text-center" cols="12">
                Cargando Servicio
            </v-col>
            <v-col cols="6">
                <v-progress-linear indeterminate rounded height="6"></v-progress-linear>
            </v-col>
        </v-row>

        <v-alert v-else-if="!status" color="error" icon="$error" :text="message || msg">
        </v-alert>

        <div v-else-if="status">
            <div class="text-center mb-5 text-uppercase">
                <h3>Detalle del servicio</h3>
            </div>
            <v-row>
                <v-col cols="12">
                    <v-btn class="greyButton" prepend-icon="mdi-arrow-left-circle">Regresar</v-btn>
                </v-col>
                <v-col cols="12">
                    <v-card variant="outlined" class="cardServicio">
                        <v-row>
                            <v-col col="12" md="5" class="d-flex align-center justify-center pr-0">

                                <v-img class="ml-1" style="height: 70%;"
                                    :src="infoServicio.logo"></v-img>
                            </v-col>

                            <v-col col="12" md="7">
                                <v-card-title class="text-h5 bg-primary text-center font-weight-bold">
                                    {{ infoServicio.servicio }}
                                </v-card-title>

                                <v-card-Text class="mt-5">
                                    <v-row>
                                        <v-col cols="12" md="6">
                                            <h3 class="font-weight-bold">Descripcion del servicio:</h3>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                           {{ infoServicio.descripcion }}
                                        </v-col>

                                        <v-col cols="12" md="6">
                                            <h3 class="font-weight-bold">Tipo de servicio: </h3>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            {{ infoServicio.tipo_servicio }}
                                        </v-col>

                                        <v-col cols="12" md="6">
                                            <h3 class="font-weight-bold">Horario:</h3>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            {{infoServicio.dia_inicio}} - {{infoServicio.dia_fin}} <br>
                                            {{infoServicio.hora_apertura}} - {{infoServicio.hora_cierre}}
                                        </v-col>

                                        <v-col cols="12" md="6">
                                            <h3 class="font-weight-bold">Rubro:</h3>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            {{infoServicio.rubro}}
                                        </v-col>

                                        <v-col cols="12" md="6">
                                            <h3 class="font-weight-bold">Precio del servicio:</h3>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            $ {{infoServicio.precio}}
                                        </v-col>

                                        <v-col cols="12" md="6">
                                            <h3 class="font-weight-bold">Recargo por servicio adomicilios</h3>
                                        </v-col>
                                        <v-col cols="12" md="6">
                                            $ {{infoServicio.precio_adomicilio}}
                                        </v-col>

                                        <v-col cols="12" class="d-flex justify-end">
                                            <v-btn class="blueButton" prepend-icon="mdi-account"
                                                @click="verPerfilMecanico(infoServicio.perfil_mecanico_id)">Perfil</v-btn>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-btn variant="outlined" block class="text-primary btnContratar"
                                                prepend-icon="mdi-wrench-cog" @click="contratarModal = true">Contratar
                                                servicio</v-btn>
                                        </v-col>
                                    </v-row>

                                </v-card-Text>

                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>

            <v-dialog v-model="contratarModal" width="auto">
                <v-card max-width="550" height="500" class="bg-greyDark">
                    <v-card-text>
                        <v-form>
                            <v-row>
                                <v-col cols="10">
                                    <h2 class="text-primary">Contratar el servicio</h2>
                                </v-col>
                                <v-col cols="2">
                                    <v-btn elevation="0" class="bg-transparent" @click="contratarModal = false">
                                        <v-icon>mdi-close-thick</v-icon>
                                    </v-btn>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field class="btnModal" color="white" label="Nombre del conductor*" required
                                        variant="solo"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field v-model="infoServicio.servicio" disabled variant="solo" class="btnModal" label="Servicio a contratar"
                                        required></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <VueDatePicker v-model="date" time-picker-inline teleport-center locale="es"
                                        cancelText="Cancelar" class="pickerDate" selectText="Aceptar"
                                        placeholder="Fecha y hora" />
                                </v-col>
                                <v-col cols="12">
                                    <v-select variant="solo" class="selectModal" label="Seleccione el tipo de servicio"
                                        :items="['Adomilicio', 'Cita en taller']"></v-select>
                                </v-col>
                                <v-col cols="12">
                                    <v-btn color="primary" type="submit" prepend-icon="mdi-car-cog">Contratar
                                        servicio</v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </div>
    </v-container>
</template>

<script setup>

// :to="{ path: '/verPiloto/' + piloto.id }" para cuando haya endpoint

import { ref, defineProps, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import notify from '@/plugins/notify.js';
import { getData } from '@/plugins/api.js';

const prop = defineProps({
    mode: {
        type: String,
        required: false,
        default: 'conductor'
    },
    id: {
        type: Number,
        required: false,
        default: null
    }
});

const router = useRouter();
const routerParams = useRoute();
const date = ref();
const contratarModal = ref(false);

const infoServicio = ref({});
const loading = ref(true);
const status = ref(false);
const message = ref('');
const msg = ref('El servicio mecanico solicitado no se ha encontrado o no esta disponible')

const verPerfilMecanico = (id) => {
    router.push({ path: `/verPerfilMecanico/${id}` });
}

const serviciosMecanico = async (id) => {
    try {
        const data = await getData(('servicio-mecanico/' + id));
        status.value = data.status;
        infoServicio.value = data.data;
        console.log('data', infoServicio.value);

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
    if (prop.id !== null) {
        serviciosMecanico(prop.id)
    } else {
        serviciosMecanico(routerParams.params.id)
    }
});
</script>

<style>
.cardServicio {
    background-color: #242424;
    border: #1279C1 solid 2px;
}

.btnContratar:hover {
    background-color: #1279C1;
    color: #FFFFFF !important;
}

.dp__input {
    box-shadow: 0 4px 8px #0000001a;
}

.dp__input::placeholder {
    color: #1279C1 !important;
}
</style>