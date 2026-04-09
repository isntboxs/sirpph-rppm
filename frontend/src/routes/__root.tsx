import {
  HeadContent,
  Scripts,
  createRootRouteWithContext,
} from '@tanstack/react-router'
import * as React from 'react'
import type { QueryClient } from '@tanstack/react-query'

import appCss from '#/styles.css?url'
import { TanstackQueryProvider } from '#/components/providers/tanstack-query-provider'
import { ThemeProvider } from '#/components/providers/theme-provider'
import { TooltipProvider } from '#/components/ui/tooltip'
import { Toaster } from '#/components/ui/sonner'

const TanStackDevtools = React.lazy(() =>
  import('@tanstack/react-devtools').then((mod) => ({
    default: mod.TanStackDevtools,
  }))
)
const TanStackRouterDevtoolsPanel = React.lazy(() =>
  import('@tanstack/react-router-devtools').then((mod) => ({
    default: mod.TanStackRouterDevtoolsPanel,
  }))
)
const ReactQueryDevtoolsPanel = React.lazy(() =>
  import('@tanstack/react-query-devtools').then((mod) => ({
    default: mod.ReactQueryDevtoolsPanel,
  }))
)

interface AppRouterContext {
  queryClient: QueryClient
}

export const Route = createRootRouteWithContext<AppRouterContext>()({
  head: () => ({
    meta: [
      {
        charSet: 'utf-8',
      },
      {
        name: 'viewport',
        content: 'width=device-width, initial-scale=1',
      },
      {
        title: 'TanStack Start Starter',
      },
    ],
    links: [
      {
        rel: 'stylesheet',
        href: appCss,
      },
    ],
  }),
  shellComponent: RootDocument,
  ssr: false,
})

function RootDocument({ children }: { children: React.ReactNode }) {
  return (
    <html lang="en" suppressHydrationWarning>
      <head>
        <HeadContent />
      </head>
      <body>
        <TanstackQueryProvider>
          <ThemeProvider defaultTheme="light" storageKey="vite-ui-theme">
            <TooltipProvider>{children}</TooltipProvider>
            <Toaster position="top-right" />
          </ThemeProvider>
          <React.Suspense fallback={null}>
            <TanStackDevtools
              config={{
                position: 'bottom-right',
              }}
              plugins={[
                {
                  name: 'Tanstack Router',
                  render: <TanStackRouterDevtoolsPanel />,
                },
                {
                  name: 'Tanstack Query',
                  render: <ReactQueryDevtoolsPanel />,
                },
              ]}
            />
          </React.Suspense>
        </TanstackQueryProvider>
        <Scripts />
      </body>
    </html>
  )
}
