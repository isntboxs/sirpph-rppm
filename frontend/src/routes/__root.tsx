import {
  HeadContent,
  Scripts,
  createRootRouteWithContext,
  redirect,
} from '@tanstack/react-router'
import { TanStackRouterDevtoolsPanel } from '@tanstack/react-router-devtools'
import { TanStackDevtools } from '@tanstack/react-devtools'
import { ReactQueryDevtoolsPanel } from '@tanstack/react-query-devtools'
import type { QueryClient } from '@tanstack/react-query'

import appCss from '#/styles.css?url'
import { TanstackQueryProvider } from '#/components/providers/tanstack-query-provider'
import { ThemeProvider } from '#/components/providers/theme-provider'
import { TooltipProvider } from '#/components/ui/tooltip'
import { Toaster } from '#/components/ui/sonner'
import { userQueryOptions } from '#/lib/api'

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
  // beforeLoad: ({ context, location }) => {
  //   const token =
  //     typeof window !== 'undefined' ? localStorage.getItem('auth_token') : null

  //   if (!token) {
  //     throw redirect({
  //       to: '/sign-in',
  //       search: {
  //         redirect: location.pathname,
  //       },
  //     })
  //   }

  //   const session = context.queryClient.ensureQueryData(userQueryOptions(token))

  //   if (!session) {
  //     throw redirect({
  //       to: '/sign-in',
  //       search: {
  //         redirect: location.pathname,
  //       },
  //     })
  //   }

  //   return { session }
  // },
  shellComponent: RootDocument,
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
        </TanstackQueryProvider>
        <Scripts />
      </body>
    </html>
  )
}
