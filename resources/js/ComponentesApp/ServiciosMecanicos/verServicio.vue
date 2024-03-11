<template>
    <v-container>
        <v-row v-if="loading" v-model="loading" class="fill-height" align-content="center" justify="center">
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
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" sm="5" class="d-flex align-center justify-center pr-md-0">
                                    <v-card-text>
                                        <v-img aspect-ratio="4/3" :src="infoServicio.logo"></v-img>
                                    </v-card-text>
                                </v-col>

                                <v-col cols="12" sm="7">
                                    <v-card-title class="text-h5 bg-primary rounded-lg text-center font-weight-bold">
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
                                                {{ infoServicio.dia_inicio }} - {{ infoServicio.dia_fin }} <br>
                                                {{ infoServicio.hora_apertura }} - {{ infoServicio.hora_cierre }}
                                            </v-col>

                                            <v-col cols="12" md="6">
                                                <h3 class="font-weight-bold">Rubro:</h3>
                                            </v-col>
                                            <v-col cols="12" md="6">
                                                {{ infoServicio.rubro }}
                                            </v-col>

                                            <v-col cols="12" md="6">
                                                <h3 class="font-weight-bold">Precio del servicio:</h3>
                                            </v-col>
                                            <v-col cols="12" md="6">
                                                $ {{ infoServicio.precio }}
                                            </v-col>

                                            <v-col cols="12" md="6">
                                                <h3 class="font-weight-bold">Recargo por servicio adomicilios</h3>
                                            </v-col>
                                            <v-col cols="12" md="6">
                                                $ {{ infoServicio.precio_adomicilio }}
                                            </v-col>

                                            <v-col cols="12">
                                                <v-btn variant="outlined" block class="text-primary btnContratar"
                                                    prepend-icon="mdi-wrench-cog"
                                                    @click="contratarModal = true">Contratar
                                                    servicio</v-btn>
                                            </v-col>
                                        </v-row>

                                    </v-card-Text>

                                </v-col>
                                <v-col cols="12">

                                    <v-card class="text-center perfilCard"
                                        @click="verPerfilMecanico(infoServicio.perfil_mecanico_id)" hover>
                                        <v-row align="center">
                                            <v-col cols="12" sm="3">
                                                <v-card-text>
                                                    <v-avatar color="grey" size="60" class="mt-4">
                                                        <v-img cover :src="infoServicio.perfil_mecanico.logo"></v-img>
                                                    </v-avatar>
                                                </v-card-text>

                                            </v-col>
                                            <v-col class="d-flex flex-column flex-sm-row">
                                                <v-card-text>
                                                    <v-icon>mdi-account</v-icon>
                                                    Representante <br> {{ infoServicio.perfil_mecanico.representante }}
                                                </v-card-text>
                                                <v-card-text v-if="infoServicio.perfil_mecanico?.nombre_taller">
                                                    <v-icon>mdi-car-cog</v-icon>
                                                    Taller Mecanico <br> {{ infoServicio.perfil_mecanico.nombre_taller
                                                    }}
                                                </v-card-text>
                                                <v-card-text v-else>
                                                    <v-icon>mdi-car-cog</v-icon>

                                                    Mecanico Independiente
                                                </v-card-text>
                                            </v-col>
                                        </v-row>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-card-text>

                    </v-card>
                </v-col>
                <v-col cols="12">
                    <v-card variant="outlined" class="cardServicio d-flex flex-column  mx-auto pa-sm-8" elevation="10">
                        <div class="d-flex flex-column flex-sm-row">
                            <div>
                                <div class="d-flex justify-center mt-auto text-h6 ">
                                    Calificación general
                                </div>

                                <div class="d-flex align-center flex-column my-auto">
                                    <div class="text-h2 mt-5">
                                        {{ rating.average }}
                                        <span class="text-h6 ml-n3">/5</span>
                                    </div>

                                    <v-rating readonly active-color="primary" empty-icon="mdi-cog-outline"
                                        full-icon="mdi-cog" :model-value="rating.average"></v-rating>
                                    <div class="px-3">{{ comentarios.length }} calificaciones</div>
                                </div>
                            </div>
                            <div style="width:100%;">
                                <v-list bg-color="transparent" class="d-flex flex-column-reverse" density="compact">
                                    <v-list-item v-for="(count, rating) in rating.counts" :key="rating">
                                        <v-progress-linear :model-value="(count / comentarios.length) * 100"
                                            class="mx-n5" color="primary" height="20" rounded></v-progress-linear>

                                        <template v-slot:prepend>
                                            <span>{{ rating }}</span>
                                            <v-icon class="mx-3" icon="mdi-cog"></v-icon>
                                        </template>

                                        <template v-slot:append>
                                            <div class="rating-values">
                                                <span class="d-flex justify-end">{{ count }}</span>
                                            </div>
                                        </template>
                                    </v-list-item>
                                </v-list>
                            </div>
                        </div>

                        <v-infinite-scroll mode="manual" @load="load">
                            <template
                                v-for="(comentario, index) in Object.values(comentarios).slice(0, comentariosMostrados)"
                                :key="index">
                                <v-card class="pa-4 ma-4">
                                    <div class="d-flex flex-column flex-sm-row justify-space-between align-center">
                                        <div class="d-flex align-center gap-10">
                                            <v-avatar :style="{ backgroundColor: avatarColor(index) }">
                                                <span class="avatar-initials">
                                                    {{ initials(comentario.user.nombre)}}
                                                </span>
                                            </v-avatar>
                                            <p>{{ comentario.user.nombre }}</p>
                                        </div>

                                        <v-rating readonly :model-value="comentario.calificacion" active-color="primary"
                                            empty-icon="mdi-cog-outline" full-icon="mdi-cog"
                                            density="compact"></v-rating>
                                    </div>

                                    <v-card-text>
                                        <h4 class="mb-3">Comentario</h4>
                                        <p class="text-justify">
                                            {{ comentario.comentario }}
                                        </p>

                                    </v-card-text>
                                </v-card>
                            </template>
                            <template v-slot:load-more="{ props }">
                                <v-btn class="bg-primary" v-bind="props" prepend-icon="mdi-refresh">Cargar mas
                                    comentarios</v-btn>

                            </template>
                            <template v-slot:empty>
                                <v-alert type="warning">¡No se encontraron comentarios!</v-alert>
                            </template>
                        </v-infinite-scroll>
                    </v-card>
                </v-col>
            </v-row>

            <v-dialog v-model="contratarModal" width="auto">
                <v-card max-width="550" class="bg-greyDark">
                    <v-card-text>
                        <v-form @submit.prevent="postContratar()" validate-on="submit lazy">
                            <v-row>
                                <v-col cols="12" class="d-flex justify-space-between">
                                    <h2 class="text-primary">Contratar el servicio</h2>

                                    <v-btn icon elevation="0" class="bg-transparent" @click="contratarModal = false">
                                        <v-icon>mdi-close-thick</v-icon>
                                    </v-btn>
                                </v-col>

                                <v-col cols="12">
                                    <v-text-field hide-details v-model="infoServicio.servicio" readonly variant="solo"
                                        label="Servicio a contratar" required></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <VueDatePicker v-model="date" time-picker-inline teleport-center :is-24="false"
                                        :min-date="minDate" locale="es" cancelText="Cancelar" class="pickerDate"
                                        selectText="Aceptar" placeholder="Fecha y hora" />
                                </v-col>
                                <v-col cols="12">
                                    <v-select v-model="form.tipo_servicio" variant="solo" class="selectModal"
                                        label="Seleccione el tipo de servicio" :items="[infoServicio.tipo_servicio]"
                                        hide-details></v-select>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field v-model="form.direccion" hide-details color="primary"
                                        label="Dirección" required variant="solo"></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-textarea v-model="form.comentario" base-color="primary" hide-details
                                        label="Comentario" color="primary" variant="solo"></v-textarea>
                                </v-col>
                                <v-col cols="12">
                                    <v-btn :loading="cargando" color="primary" type="submit"
                                        prepend-icon="mdi-car-cog">Contratar
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

import { ref, defineProps, onMounted, computed } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import notify from '@/plugins/notify.js';
import { getData, postData } from '@/plugins/api.js';
import { useAuthStore } from '@/Stores/auth';

const authStore = useAuthStore();

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
const date = ref('');
const contratarModal = ref(false);
const form = ref({});
const cargando = ref(false);
const minDate = ref(new Date());
const infoServicio = ref({});
const loading = ref(true);
const status = ref(false);
const message = ref('');
const msg = ref('El servicio mecanico solicitado no se ha encontrado o no esta disponible')
const comentarios = ref({});
const rating = ref({});
const comentariosMostrados = ref(10);


const verPerfilMecanico = (id) => {
    router.push({ path: `/verPerfilMecanico/${id}` });
}


const formatDatetime = (datetime) => {

    if (datetime === null) {
        return '';
    }

    // Verificar si datetime es un objeto Date
    if (datetime instanceof Date) {


        const year = datetime.getFullYear();
        const month = String(datetime.getMonth() + 1).padStart(2, '0');
        const day = String(datetime.getDate()).padStart(2, '0');
        const hours = String(datetime.getHours()).padStart(2, '0');
        const minutes = String(datetime.getMinutes()).padStart(2, '0');
        const seconds = String(datetime.getSeconds()).padStart(2, '0');

        const datetimeMySQL = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        console.log('Valor de datetime en formato MySQL:', datetimeMySQL);
        return datetimeMySQL;
    }

    return datetime;
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

const obtenerComentarios = async (id) => {
    try {
        const data = await getData(('comentarios-Servicios/' + id));
        comentarios.value = data.data.comentarios;
        rating.value = data.data.rating;
    } catch (error) {
        notify(error.message, 'error');
    }
}

const initials = (nameUser) => {
    const fullName = nameUser
    if (fullName) {
        const names = fullName.split(' ');
        return names.map(name => name.charAt(0)).join('').toUpperCase();
    } else {
        return '';
    }
};

const avatarColor = (index) => {
    const hue = (index * 137.508) % 360;
    return `hsl(${hue}, 70%, 70%)`;
};

const postContratar = async () => {
    try {
        cargando.value = true;

        const fechaMySQL = formatDatetime(date.value)

        form.value.fecha_contratacion = fechaMySQL;
        form.value.servicio_id = infoServicio.value.id;
        form.value.conductor_id = authStore.user.id;
        form.value.mecanico_id = infoServicio.value.perfil_mecanico_id;
        console.log(form.value)
        await postData('contratacion', form.value, { headers: { 'Content-Type': 'application/json' } }, '/serviciosContratados');
    } catch (error) {
        notify(error.message, 'error');
        console.error(error.message)
    } finally {
        contratarModal.value = false;
        cargando.value = false;
    }
}


async function load({ done }) {
    try {
        if (comentariosMostrados.value < comentarios.value.length) {
            comentariosMostrados.value += 10;
            done('ok');
        } else {
            done('empty');
        }
    } catch (error) {
        console.error('Error al cargar comentarios:', error);
        done('error');
    }
}

onMounted(() => {
    if (prop.id !== null) {
        serviciosMecanico(prop.id)
        obtenerComentarios(prop.id)
    } else {
        serviciosMecanico(routerParams.params.id)
        obtenerComentarios(routerParams.params.id)
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

.perfilCard {
    border: #1279C1 solid 3px;
    background: linear-gradient(to bottom right, #242424, #0f619b);
    color: #FFFFFF;
}

.avatar-initials {
    font-size: 14px;
    font-weight: bold;
    color: white;
}
</style>