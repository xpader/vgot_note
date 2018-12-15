<template>
  <v-app>
    <v-toolbar app>
      <v-toolbar-title class="headline text-uppercase">
        <span>Vuetify</span>
        <span class="font-weight-light">MATERIAL DESIGN VNote</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn
        flat
        href="https://github.com/vuetifyjs/vuetify/releases/latest"
        target="_blank"
      >
        <span class="mr-2">Latest Release</span>
      </v-btn>
    </v-toolbar>

    <v-content>
      <HelloWorld/>
    </v-content>

    <v-parallax :height="1500" src="https://cdn.vuetifyjs.com/images/parallax/material.jpg"></v-parallax>

    <v-navigation-drawer
        class="blue lighten-3"
        dark
        permanent
    >
      <v-list>
        <v-list-tile
            v-for="item in items"
            :key="item.title"
            @click=""
        >
          <v-list-tile-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>{{ item.title }}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>

    <v-layout row>
      <v-flex xs12 sm6 offset-sm3>
        <v-card>
          <v-toolbar color="cyan" dark>
            <v-toolbar-side-icon></v-toolbar-side-icon>

            <v-toolbar-title>Inbox</v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn icon>
              <v-icon>search</v-icon>
            </v-btn>
          </v-toolbar>

          <v-list two-line>
            <template v-for="(item, index) in items2">
              <v-subheader
                  v-if="item.header"
                  :key="item.header"
              >
                {{ item.header }}
              </v-subheader>

              <v-divider
                  v-else-if="item.divider"
                  :inset="item.inset"
                  :key="index"
              ></v-divider>

              <v-list-tile
                  v-else
                  :key="item.title"
                  avatar
                  @click=""
              >
                <v-list-tile-avatar>
                  <img :src="item.avatar">
                </v-list-tile-avatar>

                <v-list-tile-content>
                  <v-list-tile-title v-html="item.title"></v-list-tile-title>
                  <v-list-tile-sub-title v-html="item.subtitle"></v-list-tile-sub-title>
                </v-list-tile-content>
              </v-list-tile>
            </template>
          </v-list>
        </v-card>
      </v-flex>
    </v-layout>

  </v-app>
</template>

<script>
import HelloWorld from './components/HelloWorld'

export default {
  name: 'App',
  components: {
    HelloWorld
  },
  data () {
    return {
		items: [
			{ title: 'Dashboard', icon: 'dashboard' },
			{ title: 'Account', icon: 'account_box' },
			{ title: 'Admin', icon: 'gavel' }
		],
		items2: [
			{ header: 'Today' },
			{
				avatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg',
				title: 'Brunch this weekend?',
				subtitle: "<span class='text--primary'>Ali Connors</span> &mdash; I'll be in your neighborhood doing errands this weekend. Do you want to hang out?"
			},
			{ divider: true, inset: true },
			{
				avatar: 'https://cdn.vuetifyjs.com/images/lists/2.jpg',
				title: 'Summer BBQ <span class="grey--text text--lighten-1">4</span>',
				subtitle: "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend."
			},
			{ divider: true, inset: true },
			{
				avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
				title: 'Oui oui',
				subtitle: "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?"
			}
		]
    }
  }
}
</script>
