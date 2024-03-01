
        <template>
                <v-dialog width="1000" v-model="dialog" rounded="xl" persistent>
                <template v-slot:activator="{ props }">
                    <v-btn v-bind="props" class=" bg-primary" prepend-icon="mdi-square-edit-outline">
                            Modificar
                        </v-btn>
                </template>

                <template v-slot:default="{ isActive }">
                    <v-card  class="bg-greyDark">
                        <v-card-title class="d-flex justify-space-between aling-center">
                            <h3> Modificación del servicio </h3>
                            <v-btn variant="plain" icon @click="dialog= false"><v-icon>mdi-close</v-icon></v-btn>
                        </v-card-title>
                        
                        <v-form @submit.prevent="postServicio()" validate-on="submit lazy">
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" class="d-flex justify-center align-center gap-10 flex-column flex-sm-row">
                                        <v-avatar :image="selectedImage" size="150"></v-avatar>

                                        <v-file-input @change="handleImageChange" accept="image/png, image/jpeg"
                                        prepend-icon="mdi-image" label="Logo*" color="primary" variant="solo"
                                        hide-details></v-file-input>
                                        <p v-if="errorImage" class="text-error text-start text-subtitle-1">*Debe ser una imagen</p>
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
                                        <v-select v-model="form.tipo_servicio" class="file" color="primary" label="Tipo de servicio"
                                            :items="['Adomicilio','Reserva/Cita']"
                                            variant="solo"></v-select>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-textarea v-model="form.descripcion" class="areaa" color="primary" label="Descripcion del servicio"
                                            variant="solo">
                                        </v-textarea>
                                    </v-col>

                                    <v-col cols="12" md="6">
                                        <v-select v-model="form.dia_inicio" class="file" color="primary" label="Horario de Inicio" :items="dias"
                                            variant="solo"></v-select>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-select v-model="form.dia_fin" class="file" color="primary" label="Horario de Fin" :items="dias"
                                            variant="solo"></v-select>
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
                                        <v-text-field v-model="form.precio" class="file" color="primary" label="Costo del servicio" variant="solo"
                                            prefix="$"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-text-field v-model="form.precio_adomicilio" class="file" color="primary" label="Costo de recargo por adomicilio" variant="solo"
                                            prefix="$"></v-text-field>
                                    </v-col>
                                    <v-col cols="12" class="d-flex flex-xs-row justify-space-between">
                                        <v-btn prepend-icon="mdi-cancel" color="error" @click="dialog = false">Cancelar</v-btn>
                                        
                                        <v-btn :loading="cargando" type="submit" prepend-icon="mdi-car-wrench" color="primary">
                                            Guardar
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-card-text>

                        </v-form>
                    </v-card>
                    
                </template>
                </v-dialog>
            
        </template>
  

<script setup>
import { ref, watch, onMounted, defineProps} from 'vue';
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import { getData ,putData } from '@/plugins/api.js';
import { useAuthStore } from '@/Stores/auth';
import notify from '@/plugins/notify.js';
import { format, parse } from 'date-fns';


const props = defineProps({
    id: {
        type: Number,
        required: false,
        default: null
    }
});

const date = ref(null);
const dialog = ref(false);

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
const selectedImage = ref('');
const errorImage = ref(false);
const cargando = ref(false);
const image = ref('');
const idServicio = ref('');
const form = ref({})
const timeInicio = ref(null);
const timeFin = ref(null);

const handleImageChange = (event) => {
    const file = event.target.files[0];
    console.log("Archivo seleccionado:", file);
    
    if (file instanceof Blob) {
        image.value = file;

        if (file.type.startsWith('image/')) {
            selectedImage.value = URL.createObjectURL(file);
            errorImage.value = false;
        } else {
            errorImage.value = true;
            console.warn('Debe seleccionar una imagen');
        }
    } else {
        console.warn('Debe seleccionar un archivo válido');
        selectedImage.value = null;
    }
};

const formatTime = (time) => {
   // Si la hora es null, devolver una cadena vacía
   if (time === null) {
        return '';
    }

    // Verificar si la hora está en formato MySQL
    if (/^\d{2}:\d{2}:\d{2}$/.test(time)) {
        return time;
    }

    // Si la hora está en formato deseado, convertirla a formato MySQL
    const parsedDate = parse(time, 'h:mm a', new Date());
    const horaMySQL = format(parsedDate, 'HH:mm:ss');

    return horaMySQL;
}


const getServicio = async () => {
    try {
        const id = props.id;
        const data = await getData(('servicio-mecanico/' + id));

        if (!data.status) {
            notify('No se encontro el servicio', 'info')
            setTimeout(() => router.push({ path: 'inscripcionServicios' }), 3000)
        }
        form.value=data.data;
        timeInicio.value = form.value.hora_apertura;
        timeFin.value = form.value.hora_cierre;
        selectedImage.value = form.value.logo
        selectedRubro.value = form.value.rubro
        selectedServicio.value = form.value.servicio
        idServicio.value = data.data.id
        
    } catch (error) {
        notify(error.message, 'error');
    } 
};

const postServicio = async () => {
    try {
        if (image.value instanceof Blob) {
            const reader = new FileReader();
            reader.readAsDataURL(image.value);
            await new Promise((resolve, reject) => {
                reader.onload = () => {
                    form.value.logo = reader.result;
                    resolve();
                };
                reader.onerror = error => reject(error);
            });
        }
        form.value.hora_apertura = formatTime(timeInicio.value);
        form.value.hora_cierre = formatTime(timeFin.value);
        form.value.rubro = selectedRubro.value
        form.value.servicio = selectedServicio.value
        // form.value.perfil_mecanico_id = idServicio.value
        cargando.value = true;
        console.log(form.value)
        await putData(('servicio-mecanico/' + idServicio.value), form.value, { headers: { 'Content-Type': 'application/json' } }, '/inscripcionServicios');
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
    getServicio();
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