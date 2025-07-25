'use client'

import { useState } from 'react'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { useAuth } from '@/components/auth-provider'
import { User, X } from 'lucide-react'
import { toast } from 'sonner'

interface AuthDialogProps {
  isOpen: boolean
  onClose: () => void
}

export function AuthDialog({ isOpen, onClose }: AuthDialogProps) {
  const [name, setName] = useState('')
  const [email, setEmail] = useState('')
  const [isLoading, setIsLoading] = useState(false)
  const { signIn } = useAuth()

  if (!isOpen) return null

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    
    if (!name.trim() || !email.trim()) {
      toast.error('Please fill in all fields')
      return
    }

    setIsLoading(true)

    try {
      signIn(name.trim(), email.trim())
      toast.success('🎉 Welcome to Clyk! Your dashboard awaits!')
      onClose()
      setName('')
      setEmail('')
    } catch (error) {
      toast.error('Failed to sign in')
    } finally {
      setIsLoading(false)
    }
  }

  return (
    <div className="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
      <div className="w-full max-w-md max-h-[90vh] overflow-y-auto">
        <Card>
          <CardHeader className="relative">
            <button
              onClick={onClose}
              className="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 touch-manipulation"
            >
              <X className="h-4 w-4" />
            </button>
            <CardTitle className="flex items-center text-base sm:text-lg">
              <User className="mr-2 h-4 w-4 sm:h-5 sm:w-5" />
              Sign In to Clyk
            </CardTitle>
          </CardHeader>
          <CardContent className="pb-6">
            <form onSubmit={handleSubmit} className="space-y-4">
              <div className="space-y-2">
                <label htmlFor="name" className="text-sm font-medium">
                  Your Name
                </label>
                <Input
                  id="name"
                  type="text"
                  placeholder="John Doe"
                  value={name}
                  onChange={(e) => setName(e.target.value)}
                  disabled={isLoading}
                  className="text-base"
                />
              </div>
              
              <div className="space-y-2">
                <label htmlFor="email" className="text-sm font-medium">
                  Email Address
                </label>
                <Input
                  id="email"
                  type="email"
                  placeholder="john@example.com"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
                  disabled={isLoading}
                  className="text-base"
                />
              </div>

              <div className="space-y-3 pt-2">
                <Button 
                  type="submit" 
                  disabled={isLoading || !name.trim() || !email.trim()}
                  className="w-full"
                  size="lg"
                >
                  {isLoading ? 'Signing In...' : 'Sign In'}
                </Button>
                
                <p className="text-xs text-center text-muted-foreground leading-relaxed">
                  This is a demo app. Your data is stored locally in your browser.
                </p>
              </div>
            </form>
          </CardContent>
        </Card>
      </div>
    </div>
  )
}