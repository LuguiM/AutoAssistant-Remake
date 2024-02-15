<template>
    <v-container>
        <div class="text-center mb-5 text-uppercase">
            <h3>Perfil de la cuenta</h3>
        </div>

        <div class="d-flex flex-column gap-10">
            <div class="d-flex flex-column flex-sm-row mx-auto aling-items-center gap-10">
                <v-btn class="bg-primary" prepend-icon="mdi-account-cog" :disabled="editarPerfil === true"
                    @click="editarPerfil = true">Actualizar
                    Perfil</v-btn>

                    <v-btn class="bg-terceary" prepend-icon="mdi-lock-reset" :disabled="editarPerfil === true"
                    @click="cambiarContraModal = true">Cambiar
                    contraseña</v-btn>

                    <v-btn class="bg-error" prepend-icon="mdi-account-remove" :disabled="editarPerfil === true"
                    @click="eliminarPerfilModal = true">
                    Eliminar cuenta
                </v-btn>
            </div>
           
            <div class="d-flex justify-center mx-auto">
                <v-card class="bg-primary elevation-24" min-width="248" max-width="500">
                    <v-card-title class="text-h5">Información</v-card-title>
                    <v-divider color="black" :thickness="5"></v-divider>
                    <v-card-text>
                        <v-row align="center">
                            <v-col cols="12" class="d-flex gap-10">
                                <h4 class="mr-5"><v-icon>mdi-account</v-icon></h4>
                                <v-text-field v-model="datosPerfil.nombre" v-if="editarPerfil === true" label="Nombre de la cuenta"
                                    variant="solo"></v-text-field>
                                <h4 v-else>{{ datosPerfil.nombre }}</h4>
                            </v-col>
                        
                            <v-col cols="12" class="d-flex gap-10">
                                <h4 class="mr-5"><v-icon>mdi-mail</v-icon></h4>
                                <v-text-field v-model="datosPerfil.correo" v-if="editarPerfil === true" label="Correo" variant="solo"></v-text-field>
                                <h4 v-else>{{ datosPerfil.correo }}</h4>
                            </v-col>
                            
                            <v-col cols="12" class="d-flex gap-10">
                                <h4 class="mr-5"><v-icon>mdi-cake-variant</v-icon></h4>
                                <v-text-field v-model="datosPerfil.edad" v-if="editarPerfil === true" label="Edad" variant="solo"></v-text-field>
                                <h4 v-else>{{ datosPerfil.edad }} años</h4>
                            </v-col>
                            
                            <v-col cols="12" class="d-flex gap-10">
                                <h4 class="mr-5"><v-icon>mdi-smart-card</v-icon></h4>
                                <h4 v-if="conductorData.licencia == true">¿Licencia? Si</h4>

                                <h4 v-else>¿Licencia? No</h4>
                            </v-col>
                            
                            <v-col cols="2" class="d-flex gap-10">
                                <h4 class="mr-5"><v-icon>mdi-card-account-details</v-icon></h4>
                                <v-text-field v-model="conductorData.numero_licencia" v-if="editarPerfil === true && conductorData.licencia == true" label="Numero de licencia"
                                    variant="solo"></v-text-field>
                                <h4 v-else>{{conductorData.numero_licencia}}</h4>
                            </v-col>
                            
                            <v-col cols="12" class="d-flex gap-10">
                                <h4 class="mr-5"><v-icon>mdi-badge-account</v-icon></h4>
                                <h4>{{ datosPerfil.rol }}</h4>
                            </v-col>
                            
                            <v-col cols="12" class="d-flex gap-10">
                                <h4 class="mr-5"><v-icon>mdi-lock-reset</v-icon></h4>
                                <v-btn class="text-decoration-underline px-0" variant="text" :disabled="editarPerfil === true"
                                @click="cambiarContraModal = true">Cambiar
                                contraseña</v-btn>
                            </v-col>
                            
                        </v-row>
                    </v-card-text>
                    <v-card-actions v-if="editarPerfil == true">
                        <v-btn class="bg-secondary">Guardar cambios</v-btn>
                        <v-btn class="bg-error" @click="editarPerfil = false">Cancelar</v-btn>
                    </v-card-actions>
                </v-card>
            </div>
        </div>

        <!--Modal de cambiar contraseña-->
        <v-dialog width="auto" v-model="cambiarContraModal" persistent>
            <v-card class="text-center bg-greyDark">
                <v-card-title class="text-primary font-weight-bold">Cambiar contraseña</v-card-title>
                <v-card-subtitle class="pt-0">Asegúrate de que tu cuenta esté usando una contraseña larga y aleatoria para
                    mantenerla
                    segura</v-card-subtitle>
                <v-divider class="border-opacity-100" color="primary"></v-divider>
                <v-card-text>
                    <v-text-field color="primary" label="Contraseña actual" variant="solo"></v-text-field>
                    <v-text-field color="primary" label="Nueva contraseña" variant="solo"></v-text-field>
                    <v-text-field color="primary" label="Repetir nueva contraseña" variant="solo"></v-text-field>
                </v-card-text>
                <v-card-actions class="mt-3">
                    <v-btn class="bg-primary">Confimar</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="cambiarContraModal = false">Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!--Modal de Eliminar-->
        <v-dialog width="auto" v-model="eliminarPerfilModal" persistent>
            <v-card class="text-center bg-greyDark">
                <v-card-title class="text-primary font-weight-bold">Eliminar Cuenta</v-card-title>
                <v-divider class="border-opacity-100" color="primary"></v-divider>
                <v-card-text>¿Esta seguro de querer eliminar tu cuenta?</v-card-text>
                <v-card-text class="pt-0">Esta accion sera irreversible y todos tus datos <br> se borraran
                    permanentemente</v-card-text>
                <v-card-actions class="mt-3">
                    <v-btn class="bg-primary" @click="confirmarEliminar = true">Confimar</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="eliminarPerfilModal = false">Cancelar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog width="auto" v-model="confirmarEliminar" persistent>
            <v-card class="text-center bg-greyDark">
                <v-card-title class="text-primary font-weight-bold">Eliminar Cuenta</v-card-title>
                <v-divider class="border-opacity-100" color="primary"></v-divider>
                <v-card-text>Ingrese su contraseña para eliminar su cuenta</v-card-text>
                <v-card-text class="pt-0">
                    <v-text-field color="primary" label="Contraseña" variant="solo"></v-text-field>
                </v-card-text>
                <v-card-actions class="mt-3">
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="eliminarPerfil">Eliminar</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import notify from '@/plugins/notify.js';
import { getData } from '@/plugins/api.js'
import { useAuthStore } from '@/Stores/auth';



const authStore = useAuthStore();


let eliminarPerfilModal = ref(false);
const confirmarEliminar = ref(false);
const cambiarContraModal = ref(false);
const editarPerfil = ref(false);
const licencia = ref('No');
const datosPerfil = ref({});
const conductorData = ref({});


const eliminarPerfil = () => {
    confirmarEliminar.value = false
    eliminarPerfilModal.value = false
    notify('Cuenta eliminada', 'success')
}

const getPerfil = async () => {

    const id = authStore.authUser.id

    const data = await getData(('users/' + id));

    datosPerfil.value = data;
    conductorData.value = data.conductor_data

    console.log(datosPerfil.value)

}


onMounted( ()=> {
    getPerfil()
});

</script>

<style></style>