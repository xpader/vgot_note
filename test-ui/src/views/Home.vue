<template>
	<v-parallax height="100%" src="https://cdn.vuetifyjs.com/images/parallax/material.jpg">
		<v-card class="mx-auto" max-width="500">
			<v-card-title class="title font-weight-regular justify-space-between">
				<span>{{ currentTitle }}</span>
			</v-card-title>

			<v-window v-model="step">
				<v-window-item :value="1">
					<v-card-text>
						<v-text-field
							label="Email"
							value="john@vuetifyjs.com"
						></v-text-field>
						<span class="caption grey--text text--darken-1">
            This is the email you will use to login to your Vuetify account
          </span>
					</v-card-text>
				</v-window-item>

				<v-window-item :value="2">
					<v-card-text>
						<v-text-field
							label="Password"
							type="password"
						></v-text-field>
						<v-text-field
							label="Confirm Password"
							type="password"
						></v-text-field>
						<span class="caption grey--text text--darken-1">
            Please enter a password for your account
          </span>
					</v-card-text>
				</v-window-item>

				<v-window-item :value="3">
					<div class="pa-3 text-xs-center">
						<v-img
							class="mb-3"
							contain
							height="128"
							src="https://cdn.vuetifyjs.com/images/logos/v.svg"
						></v-img>
						<h3 class="title font-weight-light mb-2">Welcome to Vuetify</h3>
						<span class="caption grey--text">Thanks for signing up!</span>
					</div>
				</v-window-item>
			</v-window>

			<v-divider></v-divider>

			<v-card-actions>
				<v-btn
					:disabled="step === 1"
					flat
					@click="step--"
				>
					Back
				</v-btn>
				<v-spacer></v-spacer>
				<v-btn
					:disabled="step === 3"
					color="primary"
					depressed
					@click="step++"
				>
					Next
				</v-btn>
			</v-card-actions>
		</v-card>
	</v-parallax>
</template>

<script>
import HelloWorld from '../components/HelloWorld'

export default {
	name: 'home',
	data() {
		return {
			currentTitle: 'Sign in'
		}
	},
	components: {HelloWorld}
}
</script>
