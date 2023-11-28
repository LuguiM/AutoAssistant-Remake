<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Modificacion del Servicio</h3>
        </div>

        <v-card elevation="0">
            <v-form>
                <v-card-text>
                    <v-row>
                        <v-col cols="12" md="4">
                            <v-img 
                                src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"></v-img>
                        </v-col>
                        <v-col cols="12" md="8" class="d-flex align-center">
                            <v-file-input color="primary" class="file" variant="outlined" show-size label="Logo*"
                                accept="image/*"></v-file-input>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-select class="file" color="primary" v-model="selectedRubro" :items="rubros" label="Rubro"
                                variant="outlined"></v-select>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-select class="file" color="primary" v-model="selectedServicio" :items="servicios"
                                label="Servicio" :disabled="!selectedRubro" variant="outlined"></v-select>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-select class="file" color="primary" label="Tipo de servicio"
                                :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                                variant="outlined"></v-select>
                        </v-col>
                        <v-col cols="12">
                            <v-textarea class="areaa" color="primary" label="Descripcion del servicio"
                                variant="outlined"></v-textarea>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-select class="file" color="primary" label="Horario de Inicio" :items="dias"
                                variant="outlined"></v-select>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-select class="file" color="primary" label="Horario de Fin" :items="dias"
                                variant="outlined"></v-select>
                        </v-col>
                        <v-col cols="12" md="6">
                            <flat-pickr :config="config" v-model="date" placeholder="Hora de apertura" class="timepicker" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <flat-pickr :config="config" v-model="date" placeholder="Hora de cierre" class="timepicker" />
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field class="file" color="primary" label="Costo estimado"
                                variant="outlined" prefix="$"></v-text-field>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-text-field class="file" color="primary" label="Costo de envio"
                                variant="outlined" prefix="$"></v-text-field>
                        </v-col>
                        <v-col cols="12" class="d-sm-flex flex-xs-column">
                            <v-btn prepend-icon="mdi-cancel" color="error">Cancelar</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn type="submit" prepend-icon="mdi-car-wrench" color="primary">
                                Guardar Cambios
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-text>

            </v-form>
        </v-card>
    </v-container>
</template>

<script setup>
import { ref, watch, } from 'vue';
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

const date = ref(null);

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

watch(() => {
    return selectedRubro.value;
}, (newRubro) => {
    servicios.value = newRubro ? rubroPorServicio.value[newRubro] : [];
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
    border: #7A7A7A 1px solid;
    width: 100%;
    height: 56px;
    padding-left: 10px;

}

.timepicker::placeholder {
    padding-left: 10px;
    color: #1279C1 !important;

}
</style>