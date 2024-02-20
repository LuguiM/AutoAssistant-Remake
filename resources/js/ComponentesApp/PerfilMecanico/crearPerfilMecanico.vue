<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Crear perfil mecanico</h3>
        </div>

        <v-row>
            <v-col cols="12">
                <v-btn class="greyButton" prepend-icon="mdi-arrow-left-circle">Regresar</v-btn>
            </v-col>
            <v-col cols="12">
                <v-card class="bg-greyDark">
                    <v-form @submit.prevent="postPerfil()" validate-on="submit lazy">
                        <v-card-title class="text-center">
                            <v-avatar :image="selectedImage" size="150"></v-avatar>
                            <v-file-input @change="handleImageChange" accept="image/png, image/jpeg"
                                prepend-icon="mdi-image" label="Logo" color="primary" variant="solo"
                                hide-details></v-file-input>
                            <p v-if="errorImage" class="text-error text-start text-subtitle-1">*Debe ser una imagen</p>
                        </v-card-title>
                        <v-card-text class="mt-5">
                            <v-row>
                                <v-col cols="12" sm="6">
                                    <v-text-field label="Nombre del taller" v-model="form.nombre_taller" color="primary"
                                        variant="solo"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="5">
                                    <v-text-field label="Nombre del representante" v-model="form.representante"
                                        color="primary" variant="solo"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="1">
                                    <v-tooltip text="Establecer nombre de la cuenta">
                                        <template v-slot:activator="{ props }">
                                            <v-btn class="bg-secondary"
                                                v-bind="props"><v-icon>mdi-tooltip-account</v-icon></v-btn>
                                        </template>
                                    </v-tooltip>

                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field v-model="form.numero" label="Numero de contacto" variant="solo"
                                        color="primary"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="6">
                                    <v-text-field v-model="form.direccion" label="Dirección" color="primary"
                                        variant="solo"></v-text-field>
                                </v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn :loading="cargando" type="submit" class="bg-secondary"
                                prepend-icon="mdi-account-plus">Crear perfil</v-btn>
                            <v-spacer></v-spacer>
                        </v-card-actions>
                    </v-form>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import { ref } from 'vue';
import { postData } from '@/plugins/api.js'
import { useAuthStore } from '@/Stores/auth';
import notify from '@/plugins/notify.js';
const authStore = useAuthStore();


const selectedImage = ref('https://fakeimg.pl/600x400?text=logo/imagen');
const rules = [
    (v) => !!v || 'Campo obligatorio',
    (v) => (v && v.type.startsWith('image/')) || 'Debe ser una imagen'
];
const errorImage = ref(false);
const image = ref(null);
const form = ref({});
const cargando = ref(false);



const handleImageChange = (event) => {
    const file = event.target.files[0];
    console.log("Archivo seleccionado:", file);
    image.value = file;
    if (file) {
        if (file.type.startsWith('image/')) {
            selectedImage.value = URL.createObjectURL(file);
            errorImage.value = false;
        } else {
            errorImage.value = true;
            console.warn('Debe seleccionar una imagen');
        }
    }
};



const postPerfil = async () => {
    try {
        const formData = new FormData();

        // Agrega el archivo al objeto FormData
        formData.append('logo', image.value);

        // Agrega otros datos del formulario, si los hay
        formData.append('nombre_taller', form.value.nombre_taller);
        formData.append('representante', form.value.representante);
        formData.append('numero', form.value.numero);
        formData.append('direccion', form.value.direccion);

        console.log(image.value)
        cargando.value = true;
        const data = await postData('perfilMecanico/crear', formData, { headers: { 'Content-Type': 'multipart/form-data' } });

        if (data.errors) {
            let error = data.errors.join('\n')
            notify(error, 'error');
            console.log(image.value)

        } else {
            notify(data.message, 'success');
        }
    } catch (error) {
        notify(error.message, 'warning');
    } finally {
        cargando.value = false;
    }
}

</script>

<style lang="scss" scoped></style>