<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Inscripcion de servicios</h3>
        </div>

        <v-tabs v-model="ServicioTab" fixed-tabs bg-color="secondary" color="primary">
            <v-tab value="informacion">
                <v-icon>mdi-car-info</v-icon>
                Informacion General
            </v-tab>
            <v-tab value="horariosMontos">
                <v-icon>mdi-car-clock</v-icon>
                Horarios y Montos
            </v-tab>
        </v-tabs>
        <v-window v-model="ServicioTab">
            <v-card rounded="0" elevation="0" class="bg-greyDark">
                <v-form @submit.prevent="postServicio()" validate-on="submit lazy">
                    <v-window-item value="informacion">
                        <v-card-text>
                            <v-row>

                                <v-col cols="12"
                                    class="d-flex justify-center align-center gap-10 flex-column flex-sm-row">
                                    <v-avatar :image="selectedImage" size="150"></v-avatar>

                                    <v-file-input @change="handleImageChange" accept="image/png, image/jpeg"
                                        prepend-icon="mdi-image" label="Logo*" color="primary" variant="solo"
                                        hide-details></v-file-input>
                                    <p v-if="errorImage" class="text-error text-start text-subtitle-1">*Debe ser una
                                        imagen</p>
                                </v-col>
                                <v-col cols="12" md="4">
                                    <v-select class="file" color="primary" v-model="selectedRubro" :items="rubros"
                                        label="Rubro" variant="solo"></v-select>
                                </v-col>
                                <v-col cols="12" md="4">
                                    <v-select class="file" color="primary" v-model="selectedServicio" :items="servicios"
                                        label="Servicio" :disabled="!selectedRubro" variant="solo"></v-select>
                                </v-col>
                                <v-col cols="12" md="4">
                                    <!-- <v-select v-model="form.tipo_servicio" class="file" color="primary" label="Tipo de servicio"
                                        :items="['Adomicilio','Reserva/Cita']"
                                        variant="solo"></v-select> -->
                                    <v-combobox v-model="form.tipo_servicio" :items="['Adomicilio', 'Reserva/Cita']"
                                        variant="solo" class="file" color="primary" label="Tipo de servicio" chips
                                        multiple></v-combobox>
                                </v-col>
                                <v-col cols="12">
                                    <v-textarea v-model="form.descripcion" class="areaa" color="primary"
                                        label="Descripcion del servicio" variant="solo"></v-textarea>
                                </v-col>
                            </v-row>
                        </v-card-text>


                    </v-window-item>
                    <v-window-item value="horariosMontos">
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-select v-model="form.dia_inicio" class="file" color="primary"
                                        label="Horario de Inicio" :items="dias" variant="solo"></v-select>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-select v-model="form.dia_fin" class="file" color="primary" label="Horario de Fin"
                                        :items="dias" variant="solo"></v-select>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <flat-pickr :config="config" v-model="timeInicio" placeholder="Hora de apertura"
                                        class="timepicker" />
                                </v-col>
                                <v-col cols="12" md="6">
                                    <flat-pickr :config="config" v-model="timeFin" placeholder="Hora de cierre"
                                        class="timepicker" />
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="form.precio" class="file" color="primary"
                                        label="Costo del servicio" variant="solo" prefix="$"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field v-model="form.precio_adomicilio" class="file" color="primary"
                                        label="Costo de recargo por adomicilio" variant="solo"
                                        prefix="$"></v-text-field>
                                </v-col>
                                <v-col cols="12" class="d-flex flex-xs-row justify-space-between">
                                    <v-btn prepend-icon="mdi-cancel" color="error">Cancelar</v-btn>

                                    <v-btn :loading="cargando" type="submit" prepend-icon="mdi-car-wrench"
                                        color="primary">Inscribir
                                        servicio</v-btn>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-window-item>
                </v-form>
            </v-card>
        </v-window>
    </v-container>
</template>


<script setup>
import { ref, watch, onMounted } from 'vue';
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import { getData, postData } from '@/plugins/api.js';
import { useAuthStore } from '@/Stores/auth';
import { format, parse } from 'date-fns';

const authStore = useAuthStore();

const date = ref(null);
const ServicioTab = ref(null);

const config = ref({
    enableTime: true,
    noCalendar: true,
    dateFormat: "h:i K",
    time_24hr: false,
    disableMobile: "true",
});

const dias = ref(['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado']);

const rubroPorServicio = ref({
    "Mecanico": [
        "Cambio de bujías.",
        "Cambio de aceite y filtro.",
        "Cambio de faja del alternador",
        "Cambio de frenos o regulacion",
        "Cambio o rectificación de discos de frenos",
        "Cambios de soporte de motor",
        "Cambio de amortiguadores",
        "Cambio de líquido de frenos",
        "Cambio de motor",
        "Cambio de bomba de frenos",
        "Reapriete de suspension",
    ],
    "Lubricentro": [
        "Cambio de aceite.",
        "Lavado y lubricación de chasis.",
        "Cambio de filtro de aire.",
        "Cambio de refrigerante",
        "Lubricacion de suspencion",
        "Cambio de aceite de trasmicion",
    ],
    "Electronico": [
        " Instalación de batería",
        " Reprogramacions y configuracion de control",
        " Revisión de cableado eléctrico ",
        "Cambio de computadora ",
        " Cambio de alternador ",
        " Cambio de luces ",
        " Cambio de tablero del vehículo",
        "Instalación de scanner ",
    ],
    "General de Caja": [
        "Cambio de convertidor ",
        "Cambio de sincronizados ",
        "Cambio de flechas de trasmisión",
        "Cambio de filtro de aceite de caja",
    ],
    "Enderezado y Pintura": [
        "Enderezado de chasis ",
        "Cambio de bomper",
        "Cambio de parilla",
        "Enderezado de puertas",
        "Pintura general",
        "Pulido de espejos y faros",
        "Cambio de faldones",
    ],
    "Llanteria": [
        "Cambio de llanta",
        "Relación de fuga de llanta ",
        "Aliniado y balanceado",
        "Regulación de aire ",
    ],
});

const rubros = Object.keys(rubroPorServicio.value);
const servicios = ref([]);
const selectedRubro = ref(null);
const selectedServicio = ref(null);
const form = ref({});
const selectedImage = ref('https://fakeimg.pl/600x400?text=logo/imagen');
const errorImage = ref(false);
const cargando = ref(false);
const image = ref('');
const idMecanico = ref('');
const formValidator = (false);
const timeInicio = ref(null);
const timeFin = ref(null);

const handleImageChange = (event) => {
    const file = event.target.files[0];
    console.log("Archivo seleccionado:", file);
    image.value = file;

    // Verificar si el archivo es una instancia de Blob
    if (file instanceof Blob) {
        if (file.type.startsWith('image/')) {
            selectedImage.value = URL.createObjectURL(file);
            errorImage.value = false;
        } else {
            errorImage.value = true;
            console.warn('Debe seleccionar una imagen');
        }
    } else {
        // Manejar el caso cuando no se selecciona un archivo válido (no un Blob)
        console.warn('Debe seleccionar un archivo válido');
        // Limpiar la imagen seleccionada o realizar cualquier otra acción necesaria
        selectedImage.value = null;
    }
};

const formatTime = (time) => {
    if (time === null) {
        return ''
    }

    const parsedDate = parse(time, 'h:mm a', new Date());

    const horaMySQL = format(parsedDate, 'HH:mm:ss');

    return horaMySQL;
}


const getPerfil = async () => {
    try {
        const id = authStore.authUser.id;
        const data = await getData(('verificarPerfil/' + id));

        if (!data.status) {
            notify('No se encontro perfil mecanico', 'info')
            setTimeout(() => router.push({ path: 'perfilMecanico' }), 3000)
        }

        idMecanico.value = data.id

    } catch (error) {
        notify(error.message, 'error');
    }
};

const postServicio = async () => {
    try {
        const reader = new FileReader();
        reader.readAsDataURL(image.value);
        await new Promise((resolve, reject) => {
            reader.onload = () => {
                form.value.logo = reader.result;
                resolve();
            };
            reader.onerror = error => reject(error);
        });

        form.value.hora_apertura = formatTime(timeInicio.value);
        form.value.hora_cierre = formatTime(timeFin.value);

        form.value.rubro = selectedRubro.value
        form.value.servicio = selectedServicio.value
        form.value.perfil_mecanico_id = idMecanico.value
        cargando.value = true;
        console.log(form.value)
        await postData('servicio-mecanico', form.value, { headers: { 'Content-Type': 'application/json' } }, '/inscripcionServicios');
    } finally {
        cargando.value = false;
    }
}

watch(() => {
    return selectedRubro.value;
}, (newRubro) => {
    servicios.value = newRubro ? rubroPorServicio.value[newRubro] : [];
});

onMounted(() => {
    getPerfil();
});
</script>

<style>
.file .v-field--center-affix .v-label.v-field-label {
    color: #1279C1;
    font-weight: bold;
}

.areaa .v-label.v-field-label {
    color: #1279C1 !important;
    font-weight: bold;
}

.timepicker {
    border: #ffffff 1px solid;
    background-color: #ffffff;
    box-shadow: 0 4px 8px #0000001a;
    width: 100%;
    height: 56px;
    padding-left: 10px;

}

.timepicker::placeholder {
    padding-left: 10px;
    color: #1279C1 !important;

}
</style>