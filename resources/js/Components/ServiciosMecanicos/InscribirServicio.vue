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
            <v-card rounded="0">
                <v-form>
                    <v-window-item value="informacion">

                        <v-card-text>
                            <v-row>
                                <v-col cols="12">
                                    <v-file-input color="primary" class="file" variant="outlined" show-size
                                        label="Logo*"></v-file-input>
                                </v-col>
                                <v-col cols="12" md="4">
                                    <v-select class="file" color="primary" label="Rubro"
                                        :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                                        variant="outlined"></v-select>
                                </v-col>
                                <v-col cols="12" md="4">
                                    <v-select class="file" color="primary" label="Servicio que ofrece"
                                        :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                                        variant="outlined"></v-select>
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
                            </v-row>
                        </v-card-text>


                    </v-window-item>
                    <v-window-item value="horariosMontos">
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-select class="file" color="primary" label="Horario de Inicio"
                                        :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                                        variant="outlined"></v-select>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-select class="file" color="primary" label="Horario de Fin"
                                        :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                                        variant="outlined"></v-select>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <flat-pickr :config="config" v-model="date" placeholder="Apertura" class="timepicker" />
                                </v-col>
                                <v-col cols="12" md="6">
                                    <flat-pickr :config="config" v-model="date" placeholder="Hora de cierre"
                                        class="timepicker" />
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field class="file" color="primary" label="Costo estimado"
                                        variant="outlined"></v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field class="file" color="primary" label="Costo de envio"
                                        variant="outlined"></v-text-field>
                                </v-col>
                                <v-col cols="12" class="d-flex">
                                    <v-btn prepend-icon="mdi-cancel" color="error">Cancelar</v-btn>
                                    <v-spacer></v-spacer>
                                    <v-btn type="submit" prepend-icon="mdi-car-wrench" color="primary">Inscribir servicio</v-btn>
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
import { ref } from 'vue';
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';

const date = ref(null);
const ServicioTab = ref(null);

const config = ref({
    enableTime: true,
    noCalendar: true,
    dateFormat: "h:i K",
    time_24hr: false,
    disableMobile: "true"
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