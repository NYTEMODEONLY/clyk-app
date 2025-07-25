'use client'

import { useEffect } from 'react'
import { useParams } from 'next/navigation'
import { handleRedirect } from '@/lib/redirect-handler'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { ExternalLink, Home } from 'lucide-react'
import Link from 'next/link'

export default function RedirectPage() {
  const params = useParams()
  const shortCode = params.shortCode as string

  useEffect(() => {
    const redirect = async () => {
      try {
        const originalUrl = await handleRedirect(shortCode)
        if (originalUrl) {
          window.location.href = originalUrl
        }
      } catch (error) {
        console.error('Redirect failed:', error)
      }
    }

    if (shortCode) {
      redirect()
    }
  }, [shortCode])

  return (
    <div className="flex items-center justify-center min-h-[calc(100vh-80px)] px-4">
      <Card className="w-full max-w-md">
        <CardHeader className="text-center">
          <CardTitle className="flex items-center justify-center text-base sm:text-lg">
            <ExternalLink className="mr-2 h-4 w-4 sm:h-5 sm:w-5" />
            Redirecting...
          </CardTitle>
        </CardHeader>
        <CardContent className="text-center space-y-4">
          <div className="space-y-3">
            <div className="w-8 h-8 border-2 border-gray-300 border-t-black rounded-full animate-spin mx-auto"></div>
            <p className="text-muted-foreground text-sm sm:text-base">
              Taking you to your destination...
            </p>
          </div>
          
          <div className="pt-4">
            <p className="text-xs text-muted-foreground mb-3">
              If you're not redirected automatically:
            </p>
            <Link href="/">
              <Button variant="outline" size="sm" className="text-sm">
                <Home className="mr-2 h-4 w-4" />
                Return Home
              </Button>
            </Link>
          </div>
        </CardContent>
      </Card>
    </div>
  )
}