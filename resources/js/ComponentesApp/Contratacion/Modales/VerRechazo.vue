<template>
    <v-dialog v-model="dialog" persistent width="auto">
        <template v-slot:activator="{ props }">
            <v-btn v-if="prop.type === 'text'" v-bind="props" class="bg-primary"  prepend-icon="mdi-comment-eye-outline">Motivo de rechazo</v-btn>

            <v-btn v-else v-bind="props" variant="flat" density="compact" icon="mdi-comment-eye-outline"></v-btn>

        </template>

            <v-card class="text-center bg-greyDark">
                <v-card-title class="text-primary font-weight-bold">Motivo de rechazo</v-card-title>
                <v-divider class="border-opacity-100" color="primary"></v-divider>
                <v-card-text class="pt-0">El servicio solicitado fue rechazado por el siguiente motivo</v-card-text>

                <v-card-text>
                    <v-textarea readonly label="Observación" variant="solo" auto-grow
                    rows="4"
                    row-height="30" v-model="observacion">
                    </v-textarea>
                </v-card-text>

                <v-card-actions class="mt-3">
                    <v-spacer></v-spacer>
                    <v-btn class="bg-error" @click="dialog = false">Cerrar</v-btn>
                </v-card-actions>
            </v-card>
        
    </v-dialog>
    
</template>

<script setup>
import {ref, defineProps} from 'vue'

const dialog = ref(false);
                   
const observacion = ref("El dia escogido no daremos servicio")

const prop = defineProps({
    type: {
        type: String,
        required: true,
        default: 'icon'
    }

})

</script>