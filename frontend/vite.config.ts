import { defineConfig } from 'vite'
import { devtools } from '@tanstack/devtools-vite'
import tsconfigPaths from 'vite-tsconfig-paths'

import { tanstackStart } from '@tanstack/react-start/plugin/vite'

import viteReact from '@vitejs/plugin-react'
import tailwindcss from '@tailwindcss/vite'
// import { nitro } from 'nitro/vite'

const config = defineConfig({
  plugins: [
    devtools(),
    // nitro({
    //   rollupConfig: { external: [/^@sentry\//] },
    //   // routeRules: {
    //   //   '/api/**': {
    //   //     proxy: 'https://api-project1.marvagency.cloud/api/**',
    //   //   },
    //   // },
    // }),
    tsconfigPaths({ projects: ['./tsconfig.json'] }),
    tailwindcss(),
    tanstackStart(),
    viteReact({
      babel: {
        plugins: ['babel-plugin-react-compiler'],
      },
    }),
  ],
  server: {
    proxy: {
      '/api': {
        target: 'https://api-project1.marvagency.cloud',
        changeOrigin: true,
      },
    },
  },
})

export default config
