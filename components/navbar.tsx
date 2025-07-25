'use client'

import { useState } from 'react'
import Link from 'next/link'
import { useAuth } from '@/components/auth-provider'
import { AuthDialog } from '@/components/auth-dialog'
import { Button } from '@/components/ui/button'
import { BarChart3, LogOut, User } from 'lucide-react'

export function Navbar() {
  const { user, signOut, isLoading } = useAuth()
  const [showAuthDialog, setShowAuthDialog] = useState(false)

  const handleSignOut = () => {
    signOut()
  }

  return (
    <>
      <nav className="border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60 sticky top-0 z-40">
        <div className="container mx-auto px-4 py-3 max-w-6xl">
          <div className="flex items-center justify-between">
            <Link href="/" className="flex items-center space-x-2">
              <div className="w-8 h-8 bg-black rounded text-white flex items-center justify-center font-bold">
                C
              </div>
              <span className="text-xl font-bold">Clyk</span>
            </Link>

            <div className="flex items-center space-x-2 sm:space-x-4">
              {isLoading ? (
                <div className="w-16 sm:w-20 h-9 bg-gray-200 rounded animate-pulse" />
              ) : user ? (
                <>
                  <Link href="/dashboard">
                    <Button variant="ghost" size="sm" className="hidden sm:flex">
                      <BarChart3 className="mr-2 h-4 w-4" />
                      Dashboard
                    </Button>
                    <Button variant="ghost" size="sm" className="sm:hidden">
                      <BarChart3 className="h-4 w-4" />
                    </Button>
                  </Link>
                  
                  <div className="flex items-center space-x-2">
                    <div className="hidden sm:flex items-center space-x-2">
                      {user.avatar && (
                        <img 
                          src={user.avatar} 
                          alt={user.name}
                          className="w-6 h-6 rounded-full"
                        />
                      )}
                      <span className="text-sm text-muted-foreground max-w-24 truncate">
                        {user.name}
                      </span>
                    </div>
                    <Button
                      onClick={handleSignOut}
                      variant="outline"
                      size="sm"
                      className="hidden sm:flex"
                    >
                      <LogOut className="mr-2 h-4 w-4" />
                      Sign Out
                    </Button>
                    <Button
                      onClick={handleSignOut}
                      variant="outline"
                      size="sm"
                      className="sm:hidden"
                    >
                      <LogOut className="h-4 w-4" />
                    </Button>
                  </div>
                </>
              ) : (
                <>
                  <Button
                    onClick={() => setShowAuthDialog(true)}
                    variant="outline"
                    size="sm"
                    className="hidden sm:flex"
                  >
                    <User className="mr-2 h-4 w-4" />
                    Sign In
                  </Button>
                  <Button
                    onClick={() => setShowAuthDialog(true)}
                    variant="outline"
                    size="sm"
                    className="sm:hidden"
                  >
                    <User className="h-4 w-4" />
                  </Button>
                </>
              )}
            </div>
          </div>
        </div>
      </nav>

      <AuthDialog 
        isOpen={showAuthDialog}
        onClose={() => setShowAuthDialog(false)}
      />
    </>
  )
}